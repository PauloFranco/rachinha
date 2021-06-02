@extends('layouts.app')

@section('title', make_title('Games'))

@section('header')
    @include('games.partials.header', [
        'game' => null,
        'title'  => 'Partidas',
        'except' => [ 'view' ],
    ])
@endsection

@section('content')
  


    <div class="text-right mrg-bottom-15">
        @include('games.partials.create-button', [
            'show' => true,
        ])
    </div>

    @include('games.partials.card-list', compact('users'))

@endsection
