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
                    <h4 class="m-0 font-weight-bold text-primary">Stok Produk {{$branch_name}}</h4>
                </div>
                <div class="container text-right">
                    <a href="{{ route('stock.create',array('id' => $branch_id)) }}" class="btn btn-primary mt-3">Tambah Data</a>
                    <a href="{{ route('cetak.stock',array('id' => $branch_id)) }}" class="btn btn-primary mt-3">Cetak PDF</a>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    <div class="table-responsive">
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>#</th>
                                <th>Produk</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @forelse($stocks as $stock)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{$stock->product->nama}}</td>
                                    <td>{{$stock->stok}}</td>
                                    <td>
                                        <form action="{{ route('stock.destroy',$stock->id) }}" method="POST">
                                            <a href="{{ route('stock.edit',$stock->id) }}" class="btn btn-sm btn-primary mx-1 my-1">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mx-1 my-1" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">Data Tidak Ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{$stocks->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection