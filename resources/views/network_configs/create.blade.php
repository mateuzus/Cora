@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Cadastro de Regra de Negócio</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('network_configs.index')}}">Configurações do negócio</a></li>
                <li class="breadcrumb-item active">Cadastro de regra de negócio</li>
            </ol>
        </div>
    </div>
@endsection
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Cadastro de regras para redução de preços</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('network_configs.index') }}">Regras cadastradas</a></li>
                <li class="breadcrumb-item active">Cadastro de regras para redução de preços</li>
            </ol>
        </div>
    </div>
@endsection
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Cadastro de Regras Para Redução de Preços</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('network_configs.index') }}">Grupo Econômico</a></li>
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
                            'url'=>route("network_configs.store"),
                             'files'=>true,
                     ]) }}
                    <div class="card-header">
                        <h3 class="card-title">Cadastro de Rede</h3>
                    </div>
                    <div class="card-body">
                            @include("network_configs._form")
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
