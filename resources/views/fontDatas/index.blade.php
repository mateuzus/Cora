@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listagem de fonte de dados</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Fonte de dados</li>
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

                    <div class="card-header">
                        <h3 class="card-title">Fonte de Dados</h3>
                        <div class="card-tools">
                            <a class="btn btn-tool" href="{{ route('fontDatas.create') }}">
                                <i class="fas fa-plus"></i> Cadastrar
                            </a>
                        </div>
                    </div>


                    <div class="card-body">
                        <table class="table table-responsive-lg table-striped table-hover">
                            <thead>
                            <tr>

                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Data de criação</th>
                                <th scope="col">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fontDatas as $fontData)
                                <tr>
                                    <td>{{ $fontData->id }}</td>
                                    <td>{{ $fontData->name }}</td>
                                    <td>{{ $fontData->type }}</td>
                                    <td>{{ $fontData->created_at->format('d/m/Y - h:m:s') }}</td>
                                    <td>

                                        <a href="{{ route('fontDatas.edit', $fontData->id) }}" class="btn btn-sm btn-warning btn-block"><i class="fas fa-edit"></i> Editar</a>
                                        <a href="{{ route('fontDatas.show', $fontData->id) }}" class="btn btn-sm btn-info btn-block"><i class="fas fa-eye"></i> Detalhes</a>


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
