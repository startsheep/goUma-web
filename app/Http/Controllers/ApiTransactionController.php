<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\DetailTransactions;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use Nette\Utils\DateTime;

class ApiTransactionController extends Controller
{
    public function showTransaction($id): JsonResponse
    {
        $sql = Transaction::with('user')->where('user_id', $id)->get();
        return response()->json($sql);
    }

    public function showDetailTransaction($id): JsonResponse
    {
        $sql = DetailTransactions::with('product')->where('transaction_id', $id)->get();
        return response()->json($sql);
    }
    public function saveTransaction(Request $request)
    {

        $params = $request->except('_token');
        $saved = false;

        $saved = DB::transaction(function () use ($params) {
            $dt = new DateTime();
            $transaction = Transaction::create([
                'kode' => time(),
                'user_id' => $params['userid'],
                'branch_id' => 1,
                'kurir_id' => 1,
                'tanggal' => $dt->format('Y-m-d'),
                'total' => $params['total'],
                'metode' => $params['metode'],
                'status' => '0',
            ]);
            $keranjang = json_decode($params['listkeranjang']);
            foreach($keranjang as $k){
                $detail = DetailTransactions::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $k->idproduk,
                    'jumlah' => $k->jumlah
                ]);
            }
            $details = [
                'name' => 'FillBottle',
                'email' => null,
                'subject' => "Permintaan Transaksi",
                'msg' => 'Seorang user telah melakukan pembelian',
            ];

            Mail::to('fillbottleproject@gmail.com')->send(new ContactMail($details));
            return true;
        });
        if ($saved) {
            $sql = "Berhasil";
        } else {
            $sql = "Gagal";
        }
        return response()->json($sql);
    }
}
