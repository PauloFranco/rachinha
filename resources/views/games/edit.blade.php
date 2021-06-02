@extends('layouts.app')

@section('title', make_title('Editar partida'))

@section('header')
    @include('games.partials.header', [
        'game' => null,
        'title'  => new \Illuminate\Support\HtmlString( "Editar partida"),
        'except' => [ 'show' ],
    ])
@endsection

@section('content')
    <form action="{{route('games.update', compact('game'))}}" method="POST" accept-charset="UTF-8">
        {{ form_fields('PUT') }}

        <div class="row">
   
            <div class="col-sm-6 form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                <label for="date" class="control-label">Data da partida</label>
        
                <input type="date" name="date" id="date" class="form-control"
                       disabled maxlength="255" minlength="3"
                       placeholder="date@example.org"
                       value="{{ old('date', date('Y-m-d',strtotime($game->date))) }}">
        
                @include('common.form.errors', ['field' => 'date']) 
            </div>
            <div class="col-sm-6 form-group {{ $errors->has('size') ? 'has-error' : '' }}">
                <label for="size" class="control-label">Jogadores por time</label>
        
                <input type="number" name="size" id="size" class="form-control mask-digits"
                       disabled
                       maxlength="2" minlength="1"
                       placeholder="6"
                       value="{{ old('size', $game->size) }}">
        
                @include('common.form.errors', ['field' => 'size'])
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 form-group {{ $errors->has('confirmation') ? 'has-error' : '' }}">
                <label for="confirmation" class="control-label">Confirmados</label>
            </br>
                @foreach($users as $user)
                    <input  type="checkbox" name="confirmation[]" id="confirmation_{{$user->id}}" value="{{$user->id}}"{{$confirmados->find($user->id) ? "checked": ""}} />
                    <label  for="confirmation_{{$user->id}}"> {{$user->name}}</label><br>
                @endforeach
            </div>
        </div>


        <hr>

        <div class="form-group text-right">
            <a href="{{ route('games.index')  }}" tabindex="-1"
               class="btn btn-link">cancelar</a>

            <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i> salvar</button>
        </div>
    </form>
@endsection
