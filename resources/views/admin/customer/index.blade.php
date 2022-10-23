@extends('layouts.admin')

@section('main-content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">Pelanggan</h4>
                </div>
                <div class="container text-right">
                    <a href="{{ route('customer.create') }}" class="btn btn-primary mt-3">Tambah Data</a>
                    <a href="{{ route('cetak.customer') }}" class="btn btn-primary mt-3">Cetak PDF</a>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    <div class="table-responsive">
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Lengkap</th>
                                    <th>Kontak</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customers as $customer)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ $customer->full_name }}</td>
                                    <td>Telp : {{$customer->telp}}</br>Email : {{$customer->email}}</td>
                                    <td>{{ $customer->alamat_customer }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-sm btn-primary mx-1 my-1">Edit</a>
                                            <form action="{{ route('customer.destroy', $customer->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger mx-1 my-1" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">Data Tidak Ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{$customers->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection