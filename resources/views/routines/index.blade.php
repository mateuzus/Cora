@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listagem de Fluxos</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Rotinas</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <routine-page :user="{{ Auth::user() }}" :network="{{ Auth::user()->networks }}"></routine-page>
@endsection


