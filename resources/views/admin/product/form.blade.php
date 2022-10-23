@extends('layouts.admin')

@section('main-content')

@php
$formTitle = !empty($product) ? 'Edit' : 'Tambah';
$image = !empty($product)?$product->foto:"";
@endphp

<div class="content">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">{{$formTitle}} Produk</h4>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    @if (!empty($product))
                    {!! Form::model($product, ['url' => ['admin/product', $product->id], 'method' => 'PUT','enctype' => 'multipart/form-data']) !!}
                    {!! Form::hidden('id') !!}
                    @else
                    {!! Form::open(['url' => 'admin/product','method' => 'POST','enctype' => 'multipart/form-data']) !!}
                    @endif
                    <h6 class="heading-small text-muted mb-4">Gambar Produk</h6>
                    <div class="pl-lg-4">
                        <div class="card card-default mb-4">
                            <div class="card-background-image mt-4">
                                <div id="preview-product">
                                    @if($image!="")
                                    <img src="{{ asset('storage/'.$image) }}" width="280" height="180" />
                                    @endif

                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-12">
                                        {!! Form::file('foto', ['class' => 'form-control preview-image', 'placeholder' => 'Produst Image']) !!}
                                        @error('foto')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="heading-small text-muted mb-4">Informasi Produk</h6>

                    <div class="pl-lg-4">
                        <div class="form-group">
                            {!! Form::label('kode', 'Kode') !!}
                            {!! Form::text('kode', !empty($product) ? $product->kode : time() ,['class' => 'form-control', 'placeholder' => 'sku','readonly'=>true]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('partner_id', 'Mitra') !!}
                            {!! General::selectMultiLevel2('partner_id', $partners, [
                            'class' => 'form-control',
                            'selected' => empty($partnerID) ? "" : $partnerID,
                            'placeholder' => '-- Pilih Mitra --']) !!}
                            @if(empty($partners))
                            <span class="text-danger">Data Kosong, Admin Belum Memasukkan Data</span>
                            @endif
                            @error('partner_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('nama', 'Nama') !!}
                            {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama Product']) !!}
                            @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('category_ids', 'Kategori') !!}
                            {!! General::selectMultiLevel('category_ids[]', $categories, [
                            'class' => 'form-control',
                            'multiple' => true,
                            'selected' => !empty(old('category_ids')) ? old('category_ids') : $categoryIDs]) !!}
                            @if(empty($categories))
                            <span class="text-danger">Data Kosong, Admin Belum Memasukkan Data</span>
                            @endif
                            @error('category_ids')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('harga', 'Harga') !!}
                            {!! Form::text('harga', null, ['class' => 'form-control','onkeypress'=>'return event.charCode >= 48 && event.charCode <=57' ,'placeholder'=> 'Harga']) !!}
                                @error('harga')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('deskripsi', 'Deskripsi') !!}
                            {!! Form::textarea('deskripsi', null, ['class' => 'form-control', 'placeholder' => 'Deskripsi']) !!}
                            @error('deskripsi')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-footer pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Simpan</button>
                            <a href="{{ route('product.index') }}" class="btn btn-secondary btn-default">Kembali</a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection