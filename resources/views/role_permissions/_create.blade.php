<div class="modal fade" id="createmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open(['url'=>route('rolePermissions.store')]) !!}

            <div class="modal-header">
                <h4 class="modal-title">Nova Permissão</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">

                <div class="container-fluid">
                    @include('errors._check_form')

                    <div class="row">
                        @include('role_permissions._form')
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
