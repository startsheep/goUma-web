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
                    @include('layouts.components.flash')
                    @if (!empty($transaction))
                    {!! Form::model($transaction, ['url' => ['admin/transaction', $transaction->id], 'method' => 'PUT']) !!}
                    {!! Form::hidden('id') !!}
                    @endif
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Kode</td>
                                    <td>
                                        {!! Form::text('kode', null,['class' => 'form-control', 'placeholder' => 'Kode','readonly'=>true]) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Pemesan</td>
                                    <td>{!! Form::text('nama', null,['class' => 'form-control', 'placeholder' => 'Nama Pemesan','readonly'=>true]) !!}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pemesanan</td>
                                    <td>{!! Form::text('tanggal', null,['class' => 'form-control', 'placeholder' => 'Tanggal Pemesanan','readonly'=>true]) !!}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>{!! Form::text('total',null,['class' => 'form-control', 'placeholder' => 'Total','readonly'=>true]) !!}</td>
                                </tr>
                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td>{!! Form::select('metode', $metodes , !empty($transaction) ? $transaction->metode : null, ['class' => 'form-control', 'placeholder' => '-- Pilih Metode Pembayaran --']) !!}</td>
                                </tr>
                                <tr>
                                    <td>Status Pemesanan</td>
                                    <td>{!! Form::select('status', $statuses , !empty($transaction) ? $transaction->status : null, ['class' => 'form-control', 'placeholder' => '-- Pilih Status Pembayaran --']) !!}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-right">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {!! Form::close() !!}
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