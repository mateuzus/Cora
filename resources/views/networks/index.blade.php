@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listagem das redes cadastradas</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Redes</li>
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
                        <h3 class="card-title">Redes</h3>
                        <div class="card-tools">
                            <a class="btn btn-tool" href="{{ route('networks.create') }}">
                                <i class="fas fa-plus"></i> Cadastrar
                            </a>
                        </div>
                    </div>


                    <div class="card-body">
                        <table class="table table-responsive-lg table-striped table-hover">
                            <thead>
                            <tr>

                                <th scope="col">#</th>
                                <th scope="col">Descricao</th>
                                <th scope="col">Usuários</th>
                                <th scope="col">Situação</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($networks as $network)
                                <tr>
                                    <td>{{ $network->id }}</td>
                                    <td>{{ $network->description }}</td>
                                    <td>{{ $network->users->count()}}</td>
                                    <td>
                                        @if($network->status)
                                            <span class="badge badge-success">ATIVO</span>
                                        @else
                                            <span class="badge badge-danger">INATIVO</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('networks.edit', $network->id) }}" class="btn btn-sm btn-warning btn-block"><i class="fas fa-edit"></i> Editar</a>
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
