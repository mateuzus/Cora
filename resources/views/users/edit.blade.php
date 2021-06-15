@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edição de usuário - {{ $user->name }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Listagem de usuários</a></li>
                <li class="breadcrumb-item active">Edição de usuário - {{ $user->name }}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{ Form::model($user, [
                            'url'=>route("users.update", $user),
                             'files'=>true,
                             'method'=>"put"
                     ]) }}
                    <div class="card-header">
                        <h3 class="card-title">Edição de Usuário</h3>
                    </div>
                    <div class="card-body">
                            @include('users._form')
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
    <script>
        $(document).ready(function () {
            $("select").select2();
        })
    </script>
    @if(session()->has('message'))
        <script>
            Swal.fire({
                type: 'success',
                title: 'Tudo certo!',
                text: '{{ session()->get('message') }}',
                showConfirmButton: false,
                timer: 5000
            })
        </script>
    @endif

    @if(session()->has('error'))
        <script>
            Swal.fire({
                type: 'error',
                title: 'Ooops...',
                text: '{{ session()->get('error') }}',
                showConfirmButton: false,
                timer: 5000
            })
        </script>
    @endif

@endsection
