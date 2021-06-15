<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label" for="rede_id">Rede</label>
            {{ Form::select('network_id', $fontDataDetail, null, ['class'=> $errors->first('network_id') ?'form-control is-invalid': 'form-control', 'placeholder'=>"Selecione uma opção"]) }}
            @error('network_id')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label" for="code">Tipo</label>
            {{ Form::select('type', \App\Entities\FontData::typeArray(), null, ['id'=>'selectType', 'class'=> $errors->first('type') ?'form-control is-invalid': 'form-control', 'placeholder'=>"Selecione uma opção"]) }}
            @error('type')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label" for="name">Nome</label>
            <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Digite o nome da fonte de dados" @if(isset($fontDatas) && $fontDatas->name != "") value="{{$fontDatas->name}}"@endif>
            @error('name')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
</div>
