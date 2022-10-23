<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Kurir;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\DateTime;

class ApiUserController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            if (auth()->user()->level == 2) {
                $sql = User::where('id', auth()->user()->id)->with('kurir')->get();
            } elseif (auth()->user()->level == 3) {
                $sql = User::where('id', auth()->user()->id)->with('customer')->get();
            } else {
                $sql = 'Login Gagal';
            }
        } else {
            $sql = 'Login Gagal';
        }
        return response()->json($sql);
    }

    public function kurir(Request $request): JsonResponse
    {
        $params = $request->except('_token');
        $params['password'] = Hash::make($request->password);
        $params['level'] = '2';

        if ($request->has('foto')) {
            $params['foto'] = $this->simpanImage('kurir', 'foto', $request->file('foto'), $params['kode']);
        }
        if ($request->has('ktp')) {
            $params['ktp'] = $this->simpanImage('kurir', 'ktp', $request->file('ktp'), $params['kode']);
        }
        if ($request->has('sim')) {
            $params['sim'] = $this->simpanImage('kurir', 'sim', $request->file('sim'), $params['kode']);
        }

        $params['kode'] = time();

        $saved = false;
        $saved = DB::transaction(function () use ($params) {
            $bid = $params['branch_id'];
            $user = User::create($params);
            $user->branches()->sync($bid);
            $params['user_id'] = $user->id;
            Kurir::create($params);
            return true;
        });

        if ($saved) {
            $sql = 'Register Berhasil';
        } else {
            $sql = 'Register Gagal';
        }
        return response()->json($sql);
    }

    public function customer(Request $request): JsonResponse
    {
        $params = $request->except('_token');
        $params['password'] = Hash::make($request->password);
        $params['level'] = '3';

        if ($request->has('foto')) {
            $params['foto'] = $this->simpanImage('customer', 'foto', $request->file('foto'), $params['kode']);
        }

        $params['kode'] = time();

        $saved = false;
        $saved = DB::transaction(function () use ($params) {
            $user = User::create($params);
            $params['user_id'] = $user->id;
            Customer::create($params);
            return true;
        });

        if ($saved) {
            $sql = 'Register Berhasil';
        } else {
            $sql = 'Register Gagal';
        }
        return response()->json($sql);
    }

    private function simpanImage($user, $type, $foto, $nama)
    {
        $dt = new DateTime();

        $path = public_path('storage/uploads/' . $user . '/' . $dt->format('Y-m-d') . '/' . $nama);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
        $file = $foto;
        $name =  $type . '_' . $dt->format('Y-m-d');
        $fileName = $name . '.' . $file->getClientOriginalExtension();
        $folder = '/uploads/' . $user . '/' . $dt->format('Y-m-d') . '/' . $nama;

        $check = public_path($folder) . $fileName;

        if (File::exists($check)) {
            File::delete($check);
        }

        $filePath = $file->storeAs($folder, $fileName, 'public');
        return $filePath;
    }

    public function showCustomer($id): JsonResponse
    {
        $sql = User::with('customer')->where('id', $id)->get();
        return response()->json($sql);
    }
    public function showKurir($id): JsonResponse
    {
        $sql = User::with('kurir')->where('id', $id)->get();
        return response()->json($sql);
    }

    public function editCustomer(Request $request,$id): JsonResponse
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
            $params2['foto'] = $this->simpanImage('customer', 'foto', $request->file('foto'), $params['kode']);
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
            $sql = 'Berhasil';
        } else {
            $sql = 'Gagal';
        }
        return response()->json($sql);
    }

    public function editKurir(Request $request,$id): JsonResponse
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
            $params2['foto'] = $this->simpanImage('kurir', 'foto', $request->file('foto'), $params['kode']);
        }
        if ($ktp) {
            $params2['ktp'] = $this->simpanImage('kurir', 'ktp', $request->file('ktp'), $params['kode']);
        }
        if ($sim) {
            $params2['sim'] = $this->simpanImage('kurir', 'sim', $request->file('sim'), $params['kode']);
        }

        $params['level'] = '2';

        $saved = false;
        $saved = DB::transaction(function () use ($user, $params, $params2) {
            $bid = $params['branch_id'];
            $user->update($params);
            $user->branches()->sync($bid);
            $kurir = Kurir::where('user_id', $user->id)->first();
            $kurir->update($params2);
            return true;
        });

        if ($saved) {
            $sql = 'Berhasil';
        } else {
            $sql = 'Gagal';
        }
        return response()->json($sql);
    }
}
