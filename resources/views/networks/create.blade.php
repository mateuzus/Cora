@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Cadastro de redes</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('networks.index') }}">Redes cadastradas</a></li>
                <li class="breadcrumb-item active">Cadastro de redes</li>
            </ol>
        </div>
    </div>
@endsection
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Cadastro de Grupos Econômico</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('networks.index') }}">Grupo Econômico</a></li>
                <li class="breadcrumb-item active">Atual</li>

            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{ Form::open([
                            'url'=>route("networks.store"),
                             'files'=>true,
                     ]) }}
                    <div class="card-header">
                        <h3 class="card-title">Cadastro de Rede</h3>
                    </div>
                    <div class="card-body">
                            @include("networks._form")
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success float-right"><i class="fas fa-save "></i> Salvar</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section("footer")
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Suporte <a href="mailto:contato@includetecnologia.com.br">Falar com suporte</a>
        Versão: {{ config("app.version") }}
    </div>
    <!-- Default to the left -->
    <strong>Copyright © {{ now()->format("Y") }} <a href="https://includetecnolgoia.com.br">Include Tecnologia</a>.</strong> Todos os direitos reservados .

@endsection
@section("js")
    @include("errors.check")

@endsection
