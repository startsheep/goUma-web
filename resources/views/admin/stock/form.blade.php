@extends('layouts.admin')

@section('main-content')
@php
$formTitle = !empty($stock)?'Edit':'Tambah';
$branch_id = $bid;
@endphp
<div class="content">
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">{{$formTitle}} Stok</h4>
                </div>
                <div class="card-body">
                    @if(!empty($stock))
                    {!! Form::model($stock, ['url' => ['admin/stock',$stock->id],'method' =>'PUT'])!!}
                    {!! Form::hidden('id')!!}
                    @else
                    {!! Form::open(['route' => array('stock.store', array('branch_id' => $branch_id)),'method' => 'POST'])!!}
                    @endif

                    <div class="form-group">
                        {!! Form::label('product_id', 'Produk') !!}
                        {!! General::selectMultiLevel2('product_id', $products, [
                        'class' => 'form-control product-branch',
                        'selected' => empty($productID) ? "" : $productID,
                        'placeholder' => '-- Pilih Produk --']) !!}
                        @if(empty($products))
                        <span class="text-danger">Data Kosong, Admin Belum Memasukkan Data</span>
                        @endif
                        @error('product_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="product-information">
                        <h6 class="heading-small text-muted mb-4">Informasi Produk</h6>
                        <div class="pl-lg-4">
                            <div class="card card-default mb-4">
                                <div class="card-background-image mt-4">
                                    <img src="" id="gambar" width="300" height="300" />
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="name">Kode</label>
                                                <input type="text" id="kode" class="form-control" readonly>
                                            </div>
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="name">Nama</label>
                                                <input type="text" id="nama" class="form-control" readonly value="">
                                            </div>
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="name">Harga</span></label>
                                                <input type="text" id="harga" class="form-control" readonly value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('stok','Stok')!!}
                        {!! Form::text('stok',null,['class' =>'form-control','onkeypress'=>'return event.charCode >= 48 && event.charCode <=57' ,'placeholder'=>'Stok Produk'])!!}
                            @error('stok')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('branch_id',$branch_id,['class' =>'form-control','placeholder'=>'Stok Produk'])!!}
                    </div>
                    <div class="form-footer pt-3 border-top">
                        <button type="submit" class="btn btn-primary btn-default">Simpan</button>
                        @if(Auth::user()->level == 0)
                        <a href="{{ route('stock.index',array('id' => $branch_id)) }}" class="btn btn-secondary btn-default">Kembali</a>
                        @else
                        <a href="{{ route('stock.index',array('id' => Auth::user()->id)) }}" class="btn btn-secondary btn-default">Kembali</a>
                        @endif
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection