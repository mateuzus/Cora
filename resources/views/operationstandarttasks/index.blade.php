@extends('adminlte::page')
@section('css')

@endsection
@section('content')

    <pop-tasks-page :user="{{ Auth::user() }}" :network="{{ Auth::user()->networks }}" :pop="{{$pop}}"></pop-tasks-page>
@endsection
