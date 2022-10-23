@extends('layouts.admin')

@php
$branch_id = $bid;
$branch_name = $bname;
@endphp

@section('main-content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">Transaksi {{$branch_name}}</h4>
                </div>
                <div class="container text-right">
                    <a href="{{ route('cetak.transaction',array('id' => $branch_id)) }}" class="btn btn-primary mt-3">Cetak PDF</a>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    <div class="table-responsive">
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Pemesan</th>
                                <th>Tanggal</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{$transaction->kode}}</td>
                                    <td>{{$transaction->user->name .' '. $transaction->user->last_name}}</td>
                                    <td>{{$transaction->tanggal}}</td>
                                    <td>{{$transaction->total}}</td>
                                    <td>{{$transaction->status_name}}</td>
                                    <td>
                                        <a href="{{ route('transaction.show',$transaction->id) }}" class="btn btn-sm btn-info mx-1 my-1">Detail</a>
                                        <a href="{{ route('transaction.edit',$transaction->id) }}" class="btn btn-sm btn-primary mx-1 my-1">Edit</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">Data Tidak Ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{$transactions->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection