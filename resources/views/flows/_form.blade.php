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
            <label class="control-label" for="tipo">Tipo</label>
            {{Form::select("type", \App\Entities\Flow::selectTipo(), null, ['class'=>$errors->first('type') ?'form-control is-invalid': 'form-control', 'placeholder'=>"Selecione o tipo"])}}
            @if($errors->has('type'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('type') }}</strong>
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="isParent">É um fluxo pai?</label>
            {{ Form::select("isParent",\App\Entities\Flow::selectParent(), null, ['class'=>$errors->first('isParent') ?'form-control is-invalid': 'form-control', 'placeholder'=>"Selecione se é uma situação"]) }}
            @if($errors->has('isParent'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('isParent') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label" for="descricao">Descrição</label>
            <input id="description" type="text" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Digite a descrição da loja" @if(isset($flow) && $flow->description != "") value="{{$flow->description}}"@endif>
            @error('description')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>

</div>

