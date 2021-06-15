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
            <input id="code" type="text" name="code" class="form-control @error('code') is-invalid @enderror" placeholder="Digite o código da loja" @if(isset($departments) && $departments->code != "") value="{{$departments->code}}"@endif>
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
            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Digite o nome da loja" @if(isset($departments) && $departments->name != "") value="{{$departments->name}}"@endif>
            @error('name')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="status">Situação</label>
            {{ Form::select("status",[true=>"ATIVA", false=>"INATIVA"], null, ['class'=> $errors->first('status') ?'form-control is-invalid': 'form-control', 'placeholder'=>"Selecione a situação"]) }}
            @error('status')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
</div>
