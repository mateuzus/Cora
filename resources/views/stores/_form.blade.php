<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="rede_id">Rede</label>
            {{ Form::select('network_id', $networks, null, ['class'=> $errors->first('network_id') ?'form-control is-invalid': 'form-control', 'placeholder'=>"Selecione uma opção"]) }}
            @error('network_id')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="code">Código</label>
            <input id="code" type="text" name="code" class="form-control @error('code') is-invalid @enderror" placeholder="Digite a rede da loja" @if(isset($store) && $store->code != "") value="{{$store->code}}"@endif>
            @error('code')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="nome">Nome</label>
            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Digite o nome da loja" @if(isset($store) && $store->name != "") value="{{$store->name}}"@endif>
            @error('name')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="descricao">Descrição</label>
            <input id="description" type="text" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Digite a descrição da loja" @if(isset($store) && $store->description != "") value="{{$store->description}}"@endif>
            @error('description')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
</div>
