@extends('adminlte::page')
@section('css')

@endsection
@section('content')

    @if(Auth::user()->isSuperAdmin())
        //todo fazer nosso dashboard
    @elseif(Auth::user()->isManagerNetwork())
        <dashboard-manager :user="{{Auth::user()}}"></dashboard-manager>
    @else

        dashboard usuário
    @endif

@endsection



@section('js')
@endsection

