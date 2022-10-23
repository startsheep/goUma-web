<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Partner;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Nette\Utils\DateTime;


class ProductController extends Controller
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
        $products = Product::orderBy('nama', 'ASC');
        if ($q = $request->query('q')) {
            $products = $products->where('nama','like','%'.$q.'%')->orWhere('kode','like','%'.$q.'%');
            $this->data['q'] = $q;
        }
        $this->data['products'] = $products->paginate(10);
        return view('admin.product.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('nama', 'ASC')->get();

        $this->data['categories'] = $categories->toArray();

        $partners = Partner::orderBy('nama', 'ASC')->get();
        $this->data['partners'] = $partners->toArray();
        $this->data['partnerID'] = null;

        $this->data['product'] = null;
        $this->data['productID'] = 0;
        $this->data['categoryIDs'] = [];

        return view('admin.product.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $params = $request->except('_token');

            if ($request->has('foto')) {
                $params['foto'] = $this->simpanImage('foto', $request->file('foto'), $params['kode']);
            }

            $saved = false;
            $saved = DB::transaction(function () use ($params) {
                $product = Product::create($params);
                $product->categories()->sync($params['category_ids']);
                return true;
            });

            if ($saved) {
                Session::flash('success', 'Data Berhasil Disimpan');
            } else {
                Session::flash('error', 'Data Gagal Disimpan');
            }
        } catch (QueryException $e) {
            Session::flash('error', "Product could not be saved : SQL Error");
        }
        return redirect('admin/product');
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
        if (empty($id)) {
            return redirect('admin.product.create');
        }

        $product = Product::findOrFail($id);
        $categories = Category::orderBy('nama', 'ASC')->get();
        $partners = Partner::orderBy('nama', 'ASC')->get();

        $this->data['partners'] = $partners->toArray();
        $this->data['partnerID'] = $product->partner_id;

        $this->data['categories'] = $categories->toArray();
        $this->data['product'] = $product;
        $this->data['productID'] = $product->id;
        $this->data['categoryIDs'] = $product->categories->pluck('id')->toArray();

        return view('admin.product.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $params = $request->except('_token');
        if ($request->has('foto')) {
            $params['foto'] = $this->simpanImage('foto', $request->file('foto'), $params['kode']);
        } else {
            $params = $request->except('foto');
        }

        $product = Product::findOrFail($id);
        $saved = false;
        $saved = DB::transaction(function () use ($product, $params) {
            $product->update($params);
            $product->categories()->sync($params['category_ids']);
            return true;
        });

        if ($saved) {
            Session::flash('success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('error', 'Data Gagal Disimpan');
        }

        return redirect('admin/product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $url = $product->foto;
        $dir = public_path('storage/' . substr($url, 0, strrpos($url, '/')));
        
        $path = public_path('storage/' . $url);

        File::delete($path);

        rmdir($dir);
        if ($product->delete()) {
            Session::flash('success', 'Data Berhasil Dihapus');
        }
        return redirect('admin/product');
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
