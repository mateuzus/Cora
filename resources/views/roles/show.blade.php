@extends('adminlte::page')

{{-- @section('htmlheader_title')
    {{ trans('message.home') }}
@endsection --}}


{{-- @section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" integrity="sha256-zFnNbsU+u3l0K+MaY92RvJI6AdAVAxK3/QrBApHvlH8=" crossorigin="anonymous" />
@endsection
@section('contentheader_title')
    Listagem de FunÃ§Ãµes
@endsection --}}

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listagem de Permissões</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Listagem de perfis</a></li>
                <li class="breadcrumb-item active">Permissões</li>
            </ol>
        </div>
    </div>
@endsection


@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Visualização da função -  {{ $role->name }}</h3>
                        <div class="float-right card-tools mt-1">
                            <!-- Button trigger modal -->
                            <a href="#" data-toggle="modal" data-target="#createmodal" class="btn btn-primary btn-sm rounded-s">
                                <i class="fa fa-plus icon"></i> Adicionar Permissão
                            </a>
                            @include("role_permissions._create")
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="card-body">
                        <table  class="table table-striped">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Opção</th>
                            </tr>
                            </thead>
                            {{-- {{dd($rolepermissions)}} --}}
                            @forelse($rolepermissions as $row)
                                {{-- {{dd($row)}} --}}
                                {{-- {{dd($row->permission)}} --}}
                                <tr>
                                    <td>{!! $row->permission->name !!}</td>

                                    <td>
                                        {{ Form::open([
                                            'url'=>route('rolePermissions.destroy', [$row]),
                                            'method'=>'delete', 'class'=>'form-destroy' ]) }}
                                        <button class="btn btn-danger delete " type="submit"><i class="fa fa-trash"></i> Apagar</button>
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Nenhum registro foi encontrado!</td>
                                </tr>
                            @endforelse

                            <tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>

    <script>

        $.fn.select2.defaults.set( "theme", "bootstrap" );
        $('#permission_id').select2({
            width: null,
            containerCssClass: ':all:',
            language:"pt-br"
        });
    </script>
@endsection
