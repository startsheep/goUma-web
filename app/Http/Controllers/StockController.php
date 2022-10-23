<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\stockRequest;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StockController extends Controller
{
    public function __construct()
    {
        $this->data['bname'] = null;
        $this->data['bid'] = null;

        $this->data['q'] = null;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->query('id');
        if (Auth::user()->level == 0) {
            $stocks = Stock::where("branch_id", "=", $id)->orderBy('product_id', 'ASC');
            $branch = Branch::where("id", '=', $id)->value('nama');
            $bid = $id;
        } else {
            $bid = User::join('user_branches', 'user_branches.user_id', 'users.id')->where('users.id', $id)->value('user_branches.branch_id');
            $stocks = Stock::where("branch_id", "=", $bid)->orderBy('product_id', 'ASC');
            $branch = Branch::where("id", '=', $bid)->value('nama');
        }

        if ($q = $request->query('q')) {
            $stocks = $stocks->join('products', 'products.id', 'branch_stocks.product_id')
                ->where('products.nama', 'like', '%' . $q . '%');
            $this->data['q'] = $q;
        }

        $this->data['bname'] = $branch;
        $this->data['bid'] = $bid;
        $this->data['stocks'] = $stocks->paginate(10);
        return view('admin.stock.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($id = $request->query('id')) {
            $this->data['bid'] = $id;
        }
        $products = Product::orderBy('nama', 'ASC')->get();
        $this->data['products'] = $products->toArray();
        $this->data['productID'] = null;
        $this->data['stock'] = null;
        return view('admin.stock.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockRequest $request)
    {
        $params = $request->except('_token');
        $params['branch_id'] = $request->input('branch_id');
        if (Stock::create($params)) {
            Session::flash('success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('error', 'Data Gagal Disimpan');
        }
        if (Auth::user()->level == 0) {
            $bid = $request->input('branch_id');
        } else {
            $bid = Auth::user()->id;
        }
        return redirect('admin/stock?id=' . $bid);
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

        $stock = Stock::findOrFail($id);
        $products = Product::orderBy('nama', 'ASC')->get();
        $this->data['bid'] = $stock->branch_id;
        $this->data['stock'] = $stock;
        $this->data['products'] = $products->toArray();
        $this->data['productID'] = $stock->product_id;
        return view('admin.stock.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StockRequest $request, $id)
    {
        $params = $request->except('_token');
        $stock = Stock::findOrFail($id);

        if ($stock->update($params)) {
            Session::flash('success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('error', 'Data Gagal Disimpan');
        }

        if (Auth::user()->level == 0) {
            $bid = $stock->branch_id;
        } else {
            $bid = Auth::user()->id;
        }
        return redirect('admin/stock?id=' . $bid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $this->data['bid'] = $stock->branch_id;
        if ($stock->delete()) {
            Session::flash('success', 'Data Berhasil Dihapus');
        }

        if (Auth::user()->level == 0) {
            $bid = $stock->branch_id;
        } else {
            $bid = Auth::user()->id;
        }
        return redirect('admin/stock?id=' . $bid);
    }
}
