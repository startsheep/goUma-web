@extends('layouts.admin')

@php
$formTitle = !empty($partner)?'Edit':'Tambah';
$logo = !empty($partner)?$partner->logo:"";
@endphp
@section('main-content')
<div class="row">
    <div class="col-lg-8 order-lg-1">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{$formTitle}} Mitra</h6>
            </div>

            <div class="card-body">
                @include('layouts.components.flash')
                @if (!empty($partner))
                {!! Form::model($partner, ['url' => ['admin/partner', $partner->id], 'method' => 'PUT','enctype' => 'multipart/form-data']) !!}
                {!! Form::hidden('id') !!}
                @else
                {!! Form::open(['url' => 'admin/partner','method' => 'POST','enctype' => 'multipart/form-data']) !!}
                @endif
                <h6 class="heading-small text-muted mb-4">Logo Mitra</h6>
                <div class="pl-lg-4">
                    <div class="card card-default mb-4">
                        <div class="card-logo-image mt-4">
                            <div id="preview">
                                @if($logo!="")
                                <img src="{{ asset('storage/'.$logo) }}" class="rounded-circle" width="200px" height="200px" />
                                @endif

                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {!! Form::file('logo', ['class' => 'form-control preview-image', 'placeholder' => 'Partner Logo']) !!}
                                        @error('logo')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="heading-small text-muted mb-4">Informasi Mitra</h6>

                <div class="pl-lg-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::hidden('kode',!empty($partner) ? $partner->kode : time() ,['class' =>'form-control','placeholder'=>'Kode'])!!}
                            @error('kode')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                {!! Form::label('nama', 'Nama Partner') !!}
                                {!! Form::text('nama', null,['class' => 'form-control', 'placeholder' => 'Nama Partner']) !!}
                                @error('nama')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                {!! Form::label('alamat','Alamat') !!}
                                {!! Form::text('alamat', null,['class' => 'form-control', 'placeholder' => 'Alamat']) !!}
                                @error('alamat')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('kota','Kota/Kabupaten') !!}
                                {!! Form::text('kota', null,['class' => 'form-control', 'placeholder' => 'Kota/Kabupaten']) !!}
                                @error('kota')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('provinsi','Provinsi') !!}
                                {!! Form::text('provinsi', null,['class' => 'form-control', 'placeholder' => 'Provinsi']) !!}
                                @error('provinsi')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('kodepos','Kodepos') !!}
                                {!! Form::text('kodepos', null,['class' => 'form-control', 'placeholder' => 'Kodepos']) !!}
                                @error('kodepos')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('email','Email') !!}
                                {!! Form::email('email', null,['class' => 'form-control', 'placeholder' => 'Email']) !!}
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('telp','Telephone') !!}
                                {!! Form::text('telp', null,['class' => 'form-control', 'onkeypress'=>'return event.charCode >= 48 && event.charCode <=57' ,'placeholder'=> 'Telephone']) !!}
                                    @error('telp')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-footer pt-3 border-top">
                        <button type="submit" class="btn btn-primary btn-default">Simpan</button>
                        <a href="{{ route('partner.index') }}" class="btn btn-secondary btn-default">Kembali</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

</div>

@endsection