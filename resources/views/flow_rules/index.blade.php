@extends('adminlte::page')
@section('css')
@endsection

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listas de Regras do Fluxo - {{ $flow->name }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('flows.index') }}">Fluxos</a></li>
                <li class="breadcrumb-item active">Atual</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')

    <flow-rules-page :user="{{ Auth::user() }}" :network="{{  Auth::user()->networks->isEmpty()? \App\Entities\Network::all()  :  Auth::user()->networks  }}" :flow="{{ $flow }}"></flow-rules-page>

@endsection

@section("js")

@endsection
