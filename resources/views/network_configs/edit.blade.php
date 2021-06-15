@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edição das Configurações de Negócios</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('network_configs.index')}}">Configurações do negócio</a></li>
                <li class="breadcrumb-item active">Edição da configuração do negócio</li>
            </ol>
        </div>
    </div>
@endsection
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edição de regra de redução de preços</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('network_configs.index') }}">Regras cadastradas</a></li>
                <li class="breadcrumb-item active">Edição de regra de redução de preços</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{ Form::model($networkConfig, [
                            'url'=>route("network_configs.update", $networkConfig),
                             'files'=>true,
                             'method'=>"put"
                     ]) }}
                    <div class="card-header">
                        <h3 class="card-title">Edição de Regra de Redução de Preços</h3>
                    </div>
                    <div class="card-body">
                            @include('network_configs._form')
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
@section("js")
    @include("errors.check")

@endsection
