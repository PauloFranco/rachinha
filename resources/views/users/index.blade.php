@extends('layouts.app')

@section('title', make_title('Users'))

@section('header')
    @include('users.partials.header', [
        'user' => null,
        'title'  => 'Jogadores',
        'except' => [ 'view' ],
    ])
@endsection

@section('content')
  
    <div class="text-right mrg-bottom-15">
        @include('users.partials.create-button', [
            'show' => true,
        ])
    </div>

    @include('users.partials.card-list', compact('users'))

@endsection
