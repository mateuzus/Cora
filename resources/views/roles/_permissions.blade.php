<div class="modal fade" id="createmodal" data-backdrop='static' tabindex="-1" data-keyboard="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            {!! Form::open(['url'=>route('role_permissions.store')]) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Novas Permissões</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-12">
                    <div class="form-group{{ $errors->has("permission_id") ? ' has-error' : '' }}">
                        {!! Form::label("permission_id", 'Nome', ['class' => '']) !!}
                        {{ Form::hidden('role_id', $role->id) }}
                        <select name="permission[]" class="form-control" id="permission_id" multiple>
                            @foreach($permissions as $key => $permission)
                                <option value="{{$key}}">{{ $permissions }}</option>
                            @endforeach
                        </select>

                        {{--        {!! Form::select("permission[]", $permissions, null, ["class" => "form-control", 'multiple','id'=>'permission_id','required'])  !!}--}}
                        <small class="text-danger">{{ $errors->first("permission_id") }}</small>
                    </div>
                </div>





            </div>
            {{-- /.modal-body --}}
            <div class="modal-footer">
                {!! Form::submit( 'Salvar', ['class'=>'btn btn-primary pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
