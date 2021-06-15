@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Cadastro do detalhe da fonte da dados</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('fontDatas.index')}}">Fonte de dados</a></li>
                <li class="breadcrumb-item active">Cadastro do detalhe da fonte de dados</li>
            </ol>
        </div>
    </div>
@endsection
@section('css')
@endsection
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{ Form::open(['url'=>route('fontDataDetail.store'),'method'=>"post", 'files'=>true]) }}
                    {{ Form::hidden('font_data_id', $fontData->id) }}
                    <div class="card-header">
                        <h3 class="card-title">Cadastro de Detalhes da - <b>{{ $fontData->name }}</b></h3>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            @if($fontData->type === 'api')
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="ean_code">Url</label>
                                        {{ Form::text('url', null, ['class'=> $errors->first('url') ?'form-control is-invalid': 'form-control', 'placeholder'=>"Digite uma url"]) }}
                                        @error('url')
                                        <div class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                            @elseif($fontData->type === 'file')
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="ean_code">Ean</label>
                                        {{ Form::file('url') }}

                                        @error('url')
                                        <div class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>


                            @elseif($fontData->type === 'manual')
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="ean_code">Ean</label>
                                        {{ Form::text('ean_code', null, ['class'=> $errors->first('ean_code') ?'form-control is-invalid': 'form-control', 'placeholder'=>"Digite um Ean Code"]) }}
                                        @error('network_id')
                                        <div class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="ean_code">Descrição</label>
                                        {{ Form::text('description', null, ['class'=> $errors->first('description') ?'form-control is-invalid': 'form-control', 'placeholder'=>"Digite uma Descrição"]) }}
                                        @error('description')
                                        <div class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="value">Valor</label>
                                        {{ Form::text('value', null, ['class'=> $errors->first('value') ?'form-control is-invalid': 'form-control', 'placeholder'=>"Digite um valor"]) }}
                                        @error('value')
                                        <div class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                        </div>


                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success float-right"><i class="fas fa-save "></i> Salvar</button>
                    </div>
                    {{ Form::close() }}
                </div>

            </div>
        </div>

@endsection

@section("js")
    @include("errors.check")

@endsection

