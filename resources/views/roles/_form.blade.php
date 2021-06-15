<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="nome">Nome</label>
            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Digite o nome" @if(isset($role) && $role->name != "") value="{{$role->name}}"@endif>
            @error('name')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="nome">Slug</label>
            <input id="slug" type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="Digite o nome" @if(isset($role) && $role->slug != "") value="{{$role->slug}}"@endif>
            @error('slug')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
</div>
