<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Stock;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\DateTime;
use PDF;

class CetakController extends Controller
{
    public function cetak_product()
    {
        $products = Product::all();

        $pdf = PDF::loadview('admin.product.cetak_pdf', ['products' => $products]);
        return $pdf->stream('laporan-product-pdf');
    }

    public function cetak_partner()
    {
        $partners = Partner::all();

        $pdf = PDF::loadview('admin.partner.cetak_pdf', ['products' => $partners]);
        return $pdf->stream('laporan-mitra-pdf');
    }

    public function cetak_branch()
    {
        $branches = Branch::all();

        $pdf = PDF::loadview('admin.branch.cetak_pdf', ['branches' => $branches]);
        return $pdf->stream('laporan-cabang-pdf');
    }

    public function cetak_kurir()
    {
        if (Auth::user()->level == 0) {
            $users = User::with('kurir')->where('level', '2')->orderBy('name', 'ASC');
        } else {
            $users = User::join('user_branches', 'user_branches.user_id', 'users.id')->where('users.level', '2')->orderBy('users.name', 'ASC');
        }

        $pdf = PDF::loadview('admin.kurir.cetak_pdf', ['kurirs' => $users]);
        return $pdf->stream('laporan-kurir-pdf');
    }

    public function cetak_customer()
    {
        $customers = User::with('customer')->where('level', '3')->orderBy('name', 'ASC');

        $pdf = PDF::loadview('admin.customer.cetak_pdf', ['customers' => $customers]);
        return $pdf->stream('laporan-pelanggan-pdf');
    }

    public function cetak_stock(Request $request)
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

        $dt = new DateTime();
        $pdf = PDF::loadview('admin.stock.cetak_pdf', [
            'stocks' => $stocks,
            'bid' => $bid,
            'bname' => $branch
        ]);
        return $pdf->stream('laporan-stock-produk-' . $branch . '-' . $dt->format('Y-m-d') . '-pdf');
    }
}
