@extends('layouts.app')

@section('title', make_title('Nova Partida'))

@section('header')
    @include('games.partials.header', [
        'game' => null,
        'title'  => new \Illuminate\Support\HtmlString( "Nova partida "),
        'except' => [ 'show' ],
    ])
@endsection

@section('content')
    <form action="{{route('games.store')}}" method="POST" accept-charset="UTF-8">
        {{ form_fields( 'POST' ) }}

        <div class="row">
   
            <div class="col-sm-6 form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                <label for="date" class="control-label">Data da partida</label>
        
                <input type="date" name="date" id="date" class="form-control"
                       required maxlength="255" minlength="3"
                       placeholder="date@example.org"
                       value="{{ old('date', $game->date) }}">
        
                @include('common.form.errors', ['field' => 'date']) 
            </div>
            <div class="col-sm-6 form-group {{ $errors->has('size') ? 'has-error' : '' }}">
                <label for="size" class="control-label">Jogadores por time</label>
        
                <input type="number" name="size" id="size" class="form-control mask-digits"
                       required
                       maxlength="2" minlength="1"
                       placeholder="6"
                       value="{{ old('size', $game->size) }}">
        
                @include('common.form.errors', ['field' => 'size'])
            </div>
        </div>
        <p class="text-right">
            <a href="{{ route('home')  }}" tabindex="-1"
               class="btn btn-link">cancelar</a>

            <button class="btn btn-success"><i class="fa fa-fw fa-plus"></i> criar</button>
        </p>

    </form>
@endsection
