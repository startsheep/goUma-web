@extends('layouts.admin')

@section('main-content')
@php
$branch_id = $bid;
@endphp
<div class="content">
    <div class="row">
        <div class="col col-lg-4 col-md-4 order-lg-2">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h3 class="card-title">Ringkasan</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Kode</td>
                                    <td>{{$transaction->kode}}</td>
                                </tr>
                                <tr>
                                    <td>Nama Pemesan</td>
                                    <td>{{$transaction->user->name .' '. $transaction->user->last_name}}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pemesanan</td>
                                    <td>{{$transaction->tanggal}}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>{{General::priceFormat($transaction->total,'Rp.')}}</td>
                                </tr>
                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td>{{$transaction->metode_name}}</td>
                                </tr>
                                <tr>
                                    <td>Status Pemesanan</td>
                                    <td>{{$transaction->status_name}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col col-lg-8 col-md-8 mb-2 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h3 class="card-title">Item</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{$item->product->kode}}</td>
                                    <td>{{$item->product->nama}}</td>
                                    <td class="text-right">{{General::priceFormat($item->product->harga,'Rp.')}}</td>
                                    <td class="text-right">{{$item->jumlah}}</td>
                                    <td class="text-right">{{General::priceFormat($item->product->harga * $item->jumlah,'Rp.')}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5">
                                        <b>Total</b>
                                    </td>
                                    @php
                                    $subTotal = 0;
                                    foreach($items as $item){
                                    $subTotal = $subTotal + ($item->product->harga * $item->jumlah);
                                    }
                                    @endphp
                                    <td class="text-right">
                                        <b>{{General::priceFormat($subTotal,'Rp.')}}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('transaction.index',array('id'=>$branch_id)) }}" class="btn btn-sm btn-danger">Tutup</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection