<div class="row">
    <div class="col-sm-6  form-group {{ $errors->has('name') ? 'has-error' : '' }}">
        <label for="name" class="control-label">Nome</label>

        <input type="text" name="name" id="name" class="form-control"
               required maxlength="255" minlength="3" autofocus
               placeholder="João Silva"
               title="Este campo é obrigatório e deve conter ao menos 3 caracteres"
               value="{{ old('name', $user->name) }}">

        @include('common.form.errors', ['field' => 'name'])
    </div>
    <div class="col-sm-6 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email" class="control-label">E-mail</label>

        <input type="email" name="email" id="email" class="form-control"
               required maxlength="255" minlength="3"
               placeholder="email@example.org"
               value="{{ old('email', $user->email) }}">

        @include('common.form.errors', ['field' => 'email'])
    </div>
</div>

<div class="row">
    

    <div class="col-sm-6 form-group {{ $errors->has('skill') ? 'has-error' : '' }}">
        <label for="skill" class="control-label">Habilidade</label>

        <input type="number" name="skill" id="skill" class="form-control mask-digits"
               required
               maxlength="1" minlength="1"
               placeholder="1"
               value="{{ old('skill', $user->skill) }}">

        @include('common.form.errors', ['field' => 'skill'])
    </div>
    <div class="col-sm-6 form-group {{ $errors->has('goalkeeper') ? 'has-error' : '' }}">
        <label for="goalkeeper" class="control-label">Goleiro</label>

        <select name="goalkeeper" id="goalkeeper" class="form-control" required>
            <option value="0" {{$user->goalkeeper == "0"? 'selected':''}}>Não</option>
            <option value="1" {{$user->goalkeeper == "1"? 'selected':''}}>Sim</option>
        </select>
        @include('common.form.errors', ['field' => 'goalkeeper'])

    </div>
</div>

<div class="row">
    

   
</div>
