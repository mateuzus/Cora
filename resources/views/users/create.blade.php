@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Cadastro de usuário</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Listagem de usuários</a></li>
                <li class="breadcrumb-item active">Cadastro de usuário</li>
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
                            'url'=>route("users.store"),
                             'files'=>true,
                     ]) }}
                    <div class="card-header">
                        <h3 class="card-title">Cadastro de usuário</h3>
                    </div>
                    <div class="card-body">
                            @include("users._form")
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
