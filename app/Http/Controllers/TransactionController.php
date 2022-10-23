<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\stockRequest;
use App\Models\Branch;
use App\Models\DetailTransactions;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->data['bname'] = null;
        $this->data['bid'] = null;
        $this->data['statuses'] = Transaction::statuses();
        $this->data['metodes'] = Transaction::metodes();

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
            $transactions = Transaction::with('user')->where("branch_id", "=", $id)->orderBy('id', 'ASC');
            $branch = Branch::where("id", '=', $id)->value('nama');
            $bid = $id;
        } else {
            $bid = User::join('user_branches', 'user_branches.user_id', 'users.id')->where('users.id', $id)->value('user_branches.branch_id');
            $transactions = Transaction::with('user')->where("branch_id", "=", $bid)->orderBy('id', 'ASC');
            $branch = Branch::where("id", '=', $bid)->value('nama');
        }

        if ($q = $request->query('q')) {
            $transactions = $transactions->where('kode', 'like', '%' . $q . '%')
                ->orWhere('kode', 'like', '%' . $q . '%');
            $this->data['q'] = $q;
        }

        $this->data['bname'] = $branch;
        $this->data['bid'] = $bid;
        $this->data['transactions'] = $transactions->paginate(10);
        return view('admin.transaction.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $items = DetailTransactions::where('transaction_id', $id)->with('product')->get();
        $transaction = Transaction::findOrFail($id);
        $this->data['transaction'] = $transaction;
        $this->data['bid'] = $transaction->branch_id;
        $this->data['items'] = $items;
        return view('admin.transaction.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $items = DetailTransactions::where('transaction_id', $id)->with('product')->get();
        $transaction = Transaction::findOrFail($id);
        $this->data['transaction'] = $transaction;
        $this->data['bid'] = $transaction->branch_id;
        $this->data['items'] = $items;
        return view('admin.transaction.form', $this->data);
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
        $transaction = Transaction::findOrFail($id);

        if ($transaction->update($params)) {
            Session::flash('success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('error', 'Data Gagal Disimpan');
        }

        if (Auth::user()->level == 0) {
            $bid = $transaction->branch_id;
        } else {
            $bid = Auth::user()->id;
        }
        return redirect('admin/transaction?id=' . $bid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
