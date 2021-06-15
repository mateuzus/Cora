@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Lista dos times</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Times</li>
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
                       <h3 class="card-title">Times</h3>
                       <div class="card-tools">
                           <a class="btn btn-tool" href="{{ route('teams.create') }}">
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
                                    <th scope="col">Descrição</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($teams as $team)
                                <tr>
                                    <td>{{$team->id}}</td>
                                    <td>{{ $team->name }}</td>
                                    <td>{{ $team->description }}</td>
                                    <td>
                                        <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Editar</a>
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

