@extends('adminlte::page')
@section('css')

@endsection
@section('content')

    <routine-tasks-page :user="{{ Auth::user() }}" :network="{{ Auth::user()->networks }}" :routine="{{$routine}}"></routine-tasks-page>
@endsection
