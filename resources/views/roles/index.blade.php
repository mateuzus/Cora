@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listagem de Perfis</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Perfis</li>
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
                       <h3 class="card-title">Perfil</h3>
                       <div class="card-tools">
                           <a class="btn btn-tool" href="{{ route('roles.create') }}">
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
                                    <th scope="col">Slug</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->slug }}</td>

                                    <td>
                                        @can("roles.edit")
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Editar</a>
                                            @if($role->slug != "admin")
                                                <a class="btn btn-sm btn-info" href="{{ route('roles.show', $role) }}">
                                                    <i class="fa fa-cogs"></i> Permissões
                                                </a>
                                            @endif
                                        @endcan
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

