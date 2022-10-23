<?php

namespace App\Http\Controllers;

use App\Http\Requests\KurirRequest;
use App\Models\Branch;
use App\Models\Kurir;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Nette\Utils\DateTime;

class KurirController extends Controller
{
    public function __construct()
    {
        $this->data['q'] = null;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->level == 0) {
            $users = User::with('kurir')->where('level', '2')->orderBy('name', 'ASC');
        } else {
            // $users = User::with('kurir')->where('level', '2')->orderBy('users.name', 'ASC');
            $users = User::select(DB::raw('users.*,kurirs.ktp, kurirs.sim, kurirs.foto, kurirs.status, kurirs.alamat, kurirs.kota, kurirs.provinsi, kurirs.kodepos'))
            ->join('kurirs', 'kurirs.user_id', 'users.id')
            ->join('user_branches','user_branches.user_id','users.id')
            ->where('users.level','2')->orderBy('users.name', 'ASC');
        }
        if ($q = $request->query('q')) {
            $users = $users->where('name','like','%'.$q.'%');
            $this->data['q'] = $q;
        }
        $this->data['kurirs'] = $users->paginate(10);
        return view('admin.kurir.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::orderBy('nama', 'ASC')->get();
        $this->data['branches'] = $branches->toArray();
        $this->data['branchID'] = null;

        $this->data['user'] = null;
        return view('admin.kurir.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KurirRequest $request)
    {
        $params = $request->except('_token');
        $params['password'] = Hash::make($request->password);
        $params['level'] = '2';

        if ($request->has('foto')) {
            $params['foto'] = $this->simpanImage('foto', $request->file('foto'), $params['kode']);
        }
        if ($request->has('ktp')) {
            $params['ktp'] = $this->simpanImage('ktp', $request->file('ktp'), $params['kode']);
        }
        if ($request->has('sim')) {
            $params['sim'] = $this->simpanImage('sim', $request->file('sim'), $params['kode']);
        }

        $saved = false;
        $saved = DB::transaction(function () use ($params) {
            if (Auth::user()->level == 1) {
                $bid = User::join('user_branches', 'user_branches.user_id', 'users.id')->where('users.id', Auth::user()->id)->value('branch_id');
            } else {
                $bid = $params['branch_id'];
            }
            $user = User::create($params);
            $user->branches()->sync($bid);
            $params['user_id'] = $user->id;
            Kurir::create($params);
            return true;
        });

        if ($saved) {
            Session::flash('success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('error', 'Data Gagal Disimpan');
        }
        return redirect('admin/kurir');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::select(DB::raw('users.*,kurirs.ktp, kurirs.sim, kurirs.foto, kurirs.status, kurirs.alamat, kurirs.kota, kurirs.provinsi, kurirs.kodepos'))
            ->join('kurirs', 'kurirs.user_id', 'users.id')->where('users.id', $id)->first();
        $branch = User::join('user_branches', 'user_branches.user_id', '=', 'users.id')->where('users.id', $id)->value('branch_id');
        $this->data['kurir'] = $user;

        $branches = Branch::orderBy('nama', 'ASC')->get();

        $this->data['branches'] = $branches->toArray();
        $this->data['branchID'] = $branch;
        return view('admin.kurir.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KurirRequest $request, $id)
    {
        $foto = false;
        $ktp = false;
        $sim = false;
        $pass = false;

        $user = User::findOrFail($id);
        $params = $request->except('_token');

        $k = array('_token', 'alamat', 'kota', 'provinsi', 'kodepos', 'foto', 'ktp', 'sim');
        $u = array('_token', 'name', 'last_name', 'email', 'level', 'telp', 'branch_id', 'password');

        if ($request->filled('password')) {
            $pass = true;
        } else {
            array_push($k, 'password');
        }
        if ($request->has('foto')) {
            $foto = true;
        } else {
            array_push($u, 'foto');
        }
        if ($request->has('ktp')) {
            $ktp = true;
        } else {
            array_push($u, 'ktp');
        }
        if ($request->has('sim')) {
            $sim = true;
        } else {
            array_push($u, 'sim');
        }

        $params = $request->except($k);
        $params2 = $request->except($u);

        if ($pass) {
            $params['password'] = Hash::make($request->password);
        }
        if ($foto) {
            $params2['foto'] = $this->simpanImage('foto', $request->file('foto'), $params['kode']);
        }
        if ($ktp) {
            $params2['ktp'] = $this->simpanImage('ktp', $request->file('ktp'), $params['kode']);
        }
        if ($sim) {
            $params2['sim'] = $this->simpanImage('sim', $request->file('sim'), $params['kode']);
        }

        $params['level'] = '2';

        $saved = false;
        $saved = DB::transaction(function () use ($user, $params, $params2) {
            if (Auth::user()->level == 1) {
                $bid = User::join('user_branches', 'user_branches.user_id', 'users.id')->where('users.id', Auth::user()->id)->value('branch_id');
            } else {
                $bid = $params['branch_id'];
            }
            $user->update($params);
            $user->branches()->sync($bid);
            $kurir = Kurir::where('user_id', $user->id)->first();
            $kurir->update($params2);
            return true;
        });

        if ($saved) {
            Session::flash('success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('error', 'Data Gagal Disimpan');
        }
        return redirect('admin/kurir');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $foto = $user->kurir->foto;
        $ktp = $user->kurir->ktp;
        $sim = $user->kurir->sim;
        $path = public_path('storage/' . substr($foto, 0, strrpos($foto, '/')));
        $foto = public_path('storage/' . $foto);
        $ktp = public_path('storage/' . $ktp);
        $sim = public_path('storage/' . $sim);

        File::delete([$foto, $ktp, $sim]);

        rmdir($path);

        if ($user->delete()) {
            Session::flash('success', 'Data Berhasil Dihapus' . $path);
        }
        return redirect('admin/kurir');
    }

    private function simpanImage($type, $foto, $nama)
    {
        $dt = new DateTime();

        $path = public_path('storage/uploads/kurir/' . $dt->format('Y-m-d') . '/' . $nama);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
        $file = $foto;
        $name =  $type . '_' . $dt->format('Y-m-d');
        $fileName = $name . '.' . $file->getClientOriginalExtension();
        $folder = '/uploads/kurir/' . $dt->format('Y-m-d') . '/' . $nama;

        $check = public_path($folder) . $fileName;

        if (File::exists($check)) {
            File::delete($check);
        }

        $filePath = $file->storeAs($folder, $fileName, 'public');
        return $filePath;
    }
}
