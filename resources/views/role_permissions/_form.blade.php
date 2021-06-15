
<div class="col-md-12">
    <div class="form-group{{ $errors->has("permission_id") ? ' has-error' : '' }}">
        {!! Form::label("permission_id", 'Nome', ['class' => '']) !!}
        {{ Form::hidden('role_id', $role->id) }}
        <select name="permission[]" class="form-control" id="permission_id" multiple>
            @foreach($permissions as $key => $permission)
                <option value="{{$key}}">{{ $permission }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first("permission_id") }}</small>
    </div>
</div>


