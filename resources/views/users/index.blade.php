@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listagem das usuários</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Usuários</li>
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
                       <h3 class="card-title">Usuários</h3>
                       <div class="card-tools">
                           <a class="btn bg-purple" href="{{ route('users.create') }}">
                               <i class="fas fa-plus"></i> Cadastro de usuário
                           </a>
                       </div>
                   </div>

                    <div class="card-body">
                        <table class="table table-responsive-lg table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Perfils</th>
                                <th scope="col">Redes</th>
                                <th scope="col">Lojas</th>
                                <th scope="col">Nome</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">Time</th>
                                <th scope="col" class="col-1">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            {{ $role->name }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($user->networks as $network)
                                            {{ $network->description }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($user->stores as $store)
                                            <span class="badge badge-info">{{ $store->description }}</span>
                                        @endforeach
                                    </td>



                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>


                                    <td>
                                        @foreach($user->departments as $department)
                                            <span class="badge badge-info">{{ $department->name }}</span>
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach($user->teams as $team)
                                            <span class="badge badge-info">{{ $team->name }}</span>
                                        @endforeach
                                    </td>

                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning btn-block"><i class="fas fa-edit"></i> Editar</a>
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
    <script>
        $("document").ready(function () {
            $('table').DataTable({
                order: [
                    4, 'asc',
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                }
            });
        })
    </script>
@endsection
