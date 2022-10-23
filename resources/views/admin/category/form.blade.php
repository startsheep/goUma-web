@extends('layouts.admin')

@section('main-content')
@php
$formTitle = !empty($category)?'Edit':'Tamabh'
@endphp
<div class="content">
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">{{$formTitle}} Kategori</h4>
                </div>
                <div class="card-body">
                    @if(!empty($category))
                    {!! Form::model($category, ['url' => ['admin/category',$category->id],'method' =>'PUT'])!!}
                    {!! Form::hidden('id')!!}
                    @else
                    {!! Form::open(['url' => 'admin/category','method' => 'POST','enctype' => 'multipart/form-data'])!!}
                    @endif
                    <div class="form-group">
                        {!! Form::label('nama','Nama')!!}
                        {!! Form::text('nama',null,['class' =>'form-control','placeholder'=>'Nama Kategori'])!!}
                        @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('parent_id','Parent')!!}
                        {!! General::selectMultiLevel('parent_id',$categories,[
                        'class' => 'form-control',
                        'selected' => !empty(old('parent_id')) ? old('parent_id') : (!empty($category['parent_id']) ? $category['parent_id'] : ''), 'placeholder' => '-- Pilih Kategori --']) !!}
                        @error('parent_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('satuan','Satuan')!!}
                        {!! Form::text('satuan',null,['class' =>'form-control','placeholder'=>'Satuan Kategori'])!!}
                        @error('satuan')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-footer pt-3 border-top">
                        <button type="submit" class="btn btn-primary btn-default">Simpan</button>
                        <a href="{{ route('category.index') }}" class="btn btn-secondary btn-default">Kembali</a>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection