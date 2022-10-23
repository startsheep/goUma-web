<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\DateTime;

class CustomerController extends Controller
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
        $customers = User::with('customer')->where('level', '3')->orderBy('name', 'ASC');
        if ($q = $request->query('q')) {
            $customers = $customers->where('name','like','%'.$q.'%');
            $this->data['q'] = $q;
        }
        $this->data['customers'] = $customers->paginate(10);
        return view('admin.customer.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['user'] = null;
        return view('admin.customer.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(customerRequest $request)
    {
        $params = $request->except('_token');
        $params['password'] = Hash::make($request->password);
        $params['level'] = '3';

        if ($request->has('foto')) {
            $params['foto'] = $this->simpanImage('foto', $request->file('foto'), $params['kode']);
        }

        $saved = false;
        $saved = DB::transaction(function () use ($params) {
            $user = User::create($params);
            $params['user_id'] = $user->id;
            Customer::create($params);
            return true;
        });

        if ($saved) {
            Session::flash('success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('error', 'Data Gagal Disimpan');
        }
        return redirect('admin/customer');
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
        $customer = User::select(DB::raw('users.*,customers.foto, customers.alamat, customers.kota, customers.provinsi, customers.kodepos'))
            ->join('customers', 'customers.user_id', 'users.id')->where('users.id', $id)->first();
        $this->data['customer'] = $customer;
        return view('admin.customer.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(customerRequest $request, $id)
    {
        $foto = false;
        $pass = false;

        $user = User::findOrFail($id);
        $params = $request->except('_token');

        $k = array('_token', 'alamat', 'kota', 'provinsi', 'kodepos', 'foto');
        $u = array('_token', '_method', 'name', 'last_name', 'email', 'level', 'telp', 'password', 'kode');

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

        $params = $request->except($k);
        $params2 = $request->except($u);

        if ($pass) {
            $params['password'] = Hash::make($request->password);
        }
        if ($foto) {
            $params2['foto'] = $this->simpanImage('foto', $request->file('foto'), $params['kode']);
        }

        $params['level'] = '3';

        $saved = false;
        $saved = DB::transaction(function () use ($user, $params, $params2) {
            $user->update($params);
            $customer = Customer::where('user_id', $user->id);
            $customer->update($params2);
            return true;
        });

        if ($saved) {
            Session::flash('success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('error', 'Data Gagal Disimpan');
        }
        return redirect('admin/customer');
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
        $url = $user->customer->foto;
        $dir = public_path('storage/' . substr($url, 0, strrpos($url, '/')));        
        $path = public_path('storage/' . $url);

        File::delete($path);

        rmdir($dir);
        if ($user->delete()) {
            Session::flash('success', 'Data Berhasil Dihapus ');
        }
        return redirect('admin/customer');
    }

    private function simpanImage($type, $foto, $nama)
    {
        $dt = new DateTime();

        $path = public_path('storage/uploads/customer/' . $dt->format('Y-m-d') . '/' . $nama);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
        $file = $foto;
        $name =  $type . '_' . $dt->format('Y-m-d');
        $fileName = $name . '.' . $file->getClientOriginalExtension();
        $folder = '/uploads/customer/' . $dt->format('Y-m-d') . '/' . $nama;

        $check = public_path($folder) . $fileName;

        if (File::exists($check)) {
            File::delete($check);
        }

        $filePath = $file->storeAs($folder, $fileName, 'public');
        return $filePath;
    }
}
