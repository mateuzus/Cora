@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listagem das Configurações de Negócios</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Configurações do negócio</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Configurações do negócio</h3>
                        <div class="card-tools">
                            <a class="btn btn-tool" href="{{ route('network_configs.create') }}">
                                <i class="fas fa-plus"></i> Cadastrar
                            </a>
                        </div>
                    </div>


                    <div class="card-body">
                        <table class="table table-responsive-lg table-striped table-hover">
                            <thead>
                            <tr>

                                <th scope="col">#</th>
                                <th scope="col">Grupo Economico</th>
                                <th scope="col">Valor de rebaixa do preço</th>
                                <th scope="col">Situação</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($network_configs as $config)
                                <tr>
                                    <td>{{ $config->id }}</td>
                                    <td>{{ $config->network->name }}</td>
                                    <td>{{ $config->price_lowering_rules }}</td>
                                    <td>
                                        <a href="{{ route('network_configs.edit', $config->id) }}" class="btn btn-sm btn-warning btn-block"><i class="fas fa-edit"></i> Editar</a>
                                    </td>

                                </tr>
                            @endforeach


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")

@endsection
