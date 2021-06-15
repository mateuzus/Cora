@extends('adminlte::page')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Detalhes</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Detalhes da Fonte de dados</li>

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
                        <h3 class="card-title">Fonte de Dados - {{ $fontData->name }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('fontDataDetail.create', ['font_data_id'=>$fontData]) }}">Adicionar</a>
                        </div>
                    </div>
                   <div class="card-body">
                       <div class="row">
                           <div class="col-md-12">
                               <table class="table table-responsive-lg table-striped table-hover">
                                   <thead>
                                   <tr>

                                       <th scope="col">#</th>
                                       <th scope="col">Tipo</th>
                                       <th scope="col">Detalhes</th>
                                       <th scope="col">Situação</th>
                                       <th scope="col">Data de utilização</th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                       @foreach($fontData->details as $detail)
                                       <tr>

                                           <td>{{$detail->id}}</td>
                                           <td>{{$detail->fontData->type}}</td>
                                           <td>
                                               @if($detail->fontData->type == 'api')
                                                   {{ $detail->url }}
                                               @elseif($detail->fontData->type == 'file')
                                                   {{ $detail->url }}
                                               @elseif($detail->fontData->type == 'manual')
                                                   EAN: {{ $detail->ean_code }} || Descrição: {{ $detail->description }} || Valor: {{ $detail->value }}
                                               @endif

                                           </td>
                                           <td>{{ $detail->status_description }}</td>
                                           <td>{{ $detail->updated_at }}</td>
                                       </tr>
                                       @endforeach

                                   </tbody>
                               </table>
                           </div>
                       </div>
                   </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")

@endsection
