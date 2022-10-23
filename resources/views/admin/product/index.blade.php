@extends('layouts.admin')

@section('main-content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">Produk</h4>
                </div>
                <div class="container text-right">
                    <a href="{{ route('product.create') }}" class="btn btn-primary mt-3">Tambah Data</a>
                    <a href="{{ route('cetak.product') }}" class="btn btn-primary mt-3">Cetak PDF</a>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    <div class="table -responsive">
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Mitra</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ $product->kode }}</td>
                                    <td>{{ $product->nama }}</td>
                                    <td>{{$product->partner->nama}}</td>
                                    <td>
                                        <form action="{{ route('product.destroy',$product->id) }}" method="POST">
                                            <a href="{{ route('product.edit',$product->id) }}" class="btn btn-sm btn-primary mx-1 my-1">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mx-1 my-1" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">Data Tidak Ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection