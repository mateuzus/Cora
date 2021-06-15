<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label" for="name">Nome</label>
            {{ Form::text("name", null, ['class'=> $errors->first('name')? 'form-control is-invalid': 'form-control', 'placeholder'=>"Digite o nome do usuário"]) }}
            @error('name')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label" for="email">E-mail</label>
            {{ Form::email("email", null, ['class'=> $errors->first('email') ? 'form-control is-invalid': 'form-control', 'placeholder'=>"Digite o e-mail do Usuário"]) }}
            @error('email')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label" for="password">Senha</label>
            {{ Form::password("password", ['class'=> $errors->first('password')? 'form-control is-invalid': 'form-control', 'placeholder'=>"Digite a senha do Usuário"]) }}
            <span class="help-block text-gray text-sm">EX: {{ \Illuminate\Support\Str::random(9) }}</span>
            @error('password')
            <div class="invalid-feedback">
                <strong>{{$message}}</strong>
            </div>
            @enderror
        </div>
    </div>
</div>

<hr>
<h4>Outros dados</h4>

 <div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label" for="network_id">Rede</label>
            {{ Form::select("network_id[]", $networks, isset($user)? $user->networks : null, ["multiple",'class'=>'form-control  input-md', 'placeholder'=>"Selecione a Rede"]) }}
            <span class="help-block text-gray text-sm">Selecione a rede do usuário</span>
            @if($errors->has('network_id'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('network_id') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label" for="roles_id">Perfil</label>
            {{ Form::select("role_id[]", $roles, isset($user)? $user->roles : null, ["multiple",'class'=>'form-control  input-md', 'placeholder'=>"Selecione o perfil do Usuário"]) }}
            <span class="help-block text-gray text-sm">Selecione o Perfil</span>
            @if($errors->has('role_id'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('role_id') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label" for="store_id">Selecione a loja</label>
            {{ Form::select("store_id[]", $stores,isset($user)? $user->stores : null, ["multiple", 'class'=>'form-control input-md', 'placeholder'=>"Digite a loja do Usuário"]) }}
            <span class="help-block text-gray text-sm">Selecione a loja do usuário</span>
            @if($errors->has('store_id'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('store_id') }}</strong>
                </div>
            @endif
        </div>
    </div>

     <div class="col-md-4">
         <div class="form-group">
             <label class="control-label" for="department_id">Selecione o departamento</label>
             {{ Form::select("department_id[]", $departments,isset($user)? $user->departments : null, ["multiple", 'class'=>'form-control input-md', 'placeholder'=>"Digite o departamento do Usuário"]) }}
             <span class="help-block text-gray text-sm">Selecione o departamento do usuário</span>
             @if($errors->has('department_id'))
                 <div class="invalid-feedback">
                     <strong>{{ $errors->first('department_id') }}</strong>
                 </div>
             @endif
         </div>
     </div>

     <div class="col-md-4">
         <div class="form-group">
             <label class="control-label" for="team_id">Selecione o time</label>
             {{ Form::select("team_id[]", $teams,isset($user)? $user->teams : null, ["multiple", 'class'=>'form-control input-md', 'placeholder'=>"Digite o departamento do Usuário"]) }}
             <span class="help-block text-gray text-sm">Selecione o time do usuário</span>
             @if($errors->has('team_id'))
                 <div class="invalid-feedback">
                     <strong>{{ $errors->first('team_id') }}</strong>
                 </div>
             @endif
         </div>
     </div>

</div>
