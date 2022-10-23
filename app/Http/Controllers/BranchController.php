<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Nette\Utils\DateTime;

class BranchController extends Controller
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
        $branchs = Branch::orderBy('nama', 'ASC');
        if ($q = $request->query('q')) {
            $branchs = $branchs->where('nama','like','%'.$q.'%');
            $this->data['q'] = $q;
        }
        $this->data['branchs'] = $branchs->paginate(10);
        return view('admin.branch.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['branch'] = null;
        return view('admin.branch.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        $params = $request->except('_token');
        if ($request->has('foto')) {
            $params['foto'] = $this->simpanImage('foto', $request->file('foto'), $params['nama']);
        }
        if (branch::create($params)) {
            Session::flash('success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('error', 'Data Gagal Disimpan');
        }
        return redirect('admin/branch');
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
        $branch = Branch::findOrFail($id);
        $this->data['branch'] = $branch;
        return view('admin.branch.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BranchRequest $request, $id)
    {
        $params = $request->except('_token');
        if ($request->has('foto')) {
            $params['foto'] = $this->simpanImage('foto', $request->file('foto'), $params['nama']);
        } else {
            $params = $request->except('foto');
        }
        $branch = Branch::findOrFail($id);
        if ($branch->update($params)) {
            Session::flash('success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('error', 'Data Gagal Disimpan');
        }
        return redirect('admin/branch');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $url = $branch->foto;
        $dir = public_path('storage/' . substr($url, 0, strrpos($url, '/')));
        $path = public_path('storage/' . $url);

        File::delete($path);

        rmdir($dir);
        if ($branch->delete()) {
            Session::flash('success', 'Data Berhasil Dihapus');
        }
        return redirect('admin/branch');
    }

    private function simpanImage($type, $foto, $nama)
    {
        $dt = new DateTime();

        $path = public_path('storage/uploads/images/' . $dt->format('Y-m-d') . '/' . $nama);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
        $file = $foto;
        $name =  $type . '_' . $dt->format('Y-m-d');
        $fileName = $name . '.' . $file->getClientOriginalExtension();
        $folder = '/uploads/images/' . $dt->format('Y-m-d') . '/' . $nama;

        $check = public_path($folder) . $fileName;

        if (File::exists($check)) {
            File::delete($check);
        }

        $filePath = $file->storeAs($folder, $fileName, 'public');
        return $filePath;
    }
}
