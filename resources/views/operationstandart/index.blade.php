@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listagem de Fluxos</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">POPS</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')

    <pop-page :user="{{ Auth::user() }}" :network="{{  Auth::user()->networks->isEmpty()? \App\Entities\Network::all()  :  Auth::user()->networks  }}"></pop-page>
@endsection


