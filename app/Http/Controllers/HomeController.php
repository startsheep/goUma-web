<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Kurir;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $level = Auth::user()->level;
        $userid = Auth::user()->id;
        if ($level == 0) {
            $nama = "Admin";
            $admin = User::where('level', '0')->orWhere('level', '1')->count();
            $category = Category::count();
            $mitra = Partner::count();
            $branch = Branch::count();
            $product = Product::count();
            $kurir = Kurir::count();
            $customer = Customer::count();
        } elseif ($level == 1) {
            $bid = Branch::join('user_branches', 'user_branches.branch_id', 'branches.id')->where('user_branches.user_id', $userid)->value('branches.id');
            $bname = Branch::join('user_branches', 'user_branches.branch_id', 'branches.id')->where('user_branches.user_id', $userid)->value('branches.nama');
            $nama = $bname;

            $stock = Stock::where('branch_id', $bid)->count();
            $transaction = Transaction::where('branch_id', $bid)->count();
            $kurir = User::join('user_branches', 'user_branches.user_id', 'users.id')->where('user_branches.branch_id', $bid)->where('users.level','2')->count();
            $customer = Customer::count();
        }
        $this->data['admin'] = $admin ?? null;
        $this->data['category'] = $category ?? null;
        $this->data['mitra'] = $mitra ?? null;
        $this->data['branch'] = $branch ?? null;
        $this->data['product'] = $product ?? null;
        $this->data['kurir'] = $kurir ?? null;
        $this->data['customer'] = $customer ?? null;
        $this->data['stock'] = $stock ?? null;
        $this->data['transaction'] = $transaction ?? null;
        $this->data['nama'] = $nama;
        return view('home', $this->data);
    }

    public function notAdmin()
    {
        return view('notAdmin');
    }
}
