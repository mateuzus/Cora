@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listagem das lojas</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Lojas</li>
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
                       <h3 class="card-title">Lojas</h3>
                       <div class="card-tools">
                           <a class="btn btn-tool" href="{{ route('stores.create') }}">
                               <i class="fas fa-plus"></i> Cadastrar
                           </a>
                       </div>
                   </div>


                    <div class="card-body">
                        <table class="table table-responsive-lg table-striped">
                            <thead>
                                <tr>

                                    <th scope="col">#</th>
                                    <th scope="col">Rede</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($stores as $store)
                                <tr>
                                    <td>{{ $store->id }}</td>
                                    <td>{{ $store->network->description?? "SEM REDE ATRIBUÍDA" }}</td>
                                    <td>{{ $store->code }}</td>
                                    <td>{{ $store->name }}</td>
                                    <td>{{ $store->description }}</td>

                                    <td>
                                        <a href="{{ route('stores.edit', $store->id) }}" class="btn btn-sm btn-default"><i class="fas fa-edit"></i> Editar</a>
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

