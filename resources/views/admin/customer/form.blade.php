@extends('layouts.admin')

@section('main-content')
@php
$formTitle = !empty($customer)?'Edit':'Tambah';
$foto = !empty($customer)? $customer->foto:"";
@endphp
<div class="content">
    <div class="row">
        <div class="col-lg-9">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">{{$formTitle}} Pelanggan</h4>
                </div>
                <div class="card-body">
                    @include('layouts.components.flash')
                    @if(!empty($customer))
                    {!! Form::model($customer, ['url' => ['admin/customer',$customer->id],'method' =>'PUT','enctype' => 'multipart/form-data'])!!}
                    {!! Form::hidden('id')!!}
                    @else
                    {!! Form::open(['url' => 'admin/customer','method' => 'POST','enctype' => 'multipart/form-data'])!!}
                    @endif
                    <h6 class="heading-small text-muted mb-4">Foto Profil</h6>
                    <div class="pl-lg-4">
                        <div class="card card-default mb-4">
                            <div class="card-profile-image mt-4">
                                <div id="preview-kurir">
                                    @if($foto!="")
                                    <img src="{{ asset('storage/'.$foto) }}" width="200px" height="250px" />
                                    @endif

                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {!! Form::file('foto', ['class' => 'form-control preview-image', 'placeholder' => 'Photo Profile']) !!}
                                            @error('foto')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="heading-small text-muted mb-4">Infomrasi Pelanggan</h6>

                    <div class="pl-lg-4">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::hidden('kode',!empty($customer) ? $customer->kode : time() ,['class' =>'form-control','placeholder'=>'Kode'])!!}
                                @error('kode')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('name','Nama Depan')!!}
                                    {!! Form::text('name',null,['class' =>'form-control','placeholder'=>'Nama Depan'])!!}
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('last_name','Nama Belakang')!!}
                                    {!! Form::text('last_name',null,['class' =>'form-control','placeholder'=>'Nama Belakang'])!!}
                                    @error('last_name')
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
                                    {!! Form::text('telp',null,['class' => 'form-control','onkeypress'=>'return event.charCode >= 48 && event.charCode <=57' , 'placeholder'=> 'Telephone']) !!}
                                        @error('telp')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('password','Password')!!}
                            {{ Form::password('password', array('id' => 'password', "class" => "form-control")) }}
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-footer pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Simpan</button>
                            <a href="{{ route('customer.index') }}" class="btn btn-secondary btn-default">Kembali</a>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection