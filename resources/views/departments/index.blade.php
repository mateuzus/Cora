@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listagem de Departamentos</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Departamentos</li>

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
                       <h3 class="card-title">Mercadológico</h3>
                       <div class="card-tools">
                           <a class="btn btn-tool" href="{{ route('departments.create') }}">
                               <i class="fas fa-plus"></i> Cadastrar
                           </a>
                       </div>
                   </div>


                    <div class="card-body">
                        <table class="table table-responsive-lg table-striped table-hover">
                            <thead>
                                <tr>

                                    <th scope="col">#</th>
                                    <th scope="col">Rede</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Situação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($departments as $department)
                                <tr>
                                    <td>{{ $department->id }}</td>
                                    <td>{{ $department->network->description ?? "SEM REDE ATRIBUÍDA" }}</td>
                                    <td>{{ $department->code }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>
                                        @if($department->status)
                                            <span class="badge badge-success">ATIVO</span>
                                        @else
                                            <span class="badge badge-danger">INATIVO</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-default"><i class="fas fa-edit"></i> Editar</a>
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

