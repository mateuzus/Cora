@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listagem das Perguntas</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Perguntas</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')

    <questions-by-list-page  :user="{{ Auth::user() }}" :list='{{$listing}}'></questions-by-list-page>
@endsection

