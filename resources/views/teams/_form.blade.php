<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="name">Nome</label>
            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Digite o nome do time" @if(isset($team) && $team->name != "") value="{{$team->name}}"@endif>
            @error('name')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="description">Descrição</label>
            <input id="description" type="text" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Digite a descrição do time" @if(isset($team) && $team->description != "") value="{{$team->description}}"@endif>
            @error('description')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
</div>
