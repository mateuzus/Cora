<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label" for="name">Nome</label>
            <input id="name" type="text" name='name' class="form-control @error('name') is-invalid @enderror" placeholder="Digite o nome da rede" @if(isset($network) && $network->name != "") value='{{$network->name}}'@endif>
            @error('name')
                <div class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label" for="descricao">Descrição</label>

            <input id="description" type="text" name='description' class="form-control @error('description') is-invalid @enderror" placeholder="Digite a descrição da rede" @if(isset($network) && $network->description != "") value='{{$network->description}}'@endif>
            @error('description')
                <div class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label" for="status">Situação</label>
            {{ Form::select("status",[true=>"ATIVA", false=>"INATIVA"], null, ['class'=>$errors->first('status') ? 'form-control is-invalid': 'form-control', 'placeholder'=>"Selecione a situação da rede"]) }}
            @if($errors->has("status"))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('status') }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>
