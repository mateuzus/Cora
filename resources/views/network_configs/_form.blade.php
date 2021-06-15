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
            <label class="control-label" for="price">Regras para redução de preços</label>
            <input id="price_lowering_rules" type="number" name='price_lowering_rules' class="form-control @error('price_lowering_rules') is-invalid @enderror" placeholder="Digite a redução de preço" @if(isset($networkConfig) && $networkConfig->price_lowering_rules != "") value='{{$networkConfig->price_lowering_rules}}'@endif>
            @error('price_lowering_rules')
                <div class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </div>
            @endif
        </div>
    </div>
</div>
