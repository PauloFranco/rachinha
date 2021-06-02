@extends('layouts.app')


@section('content')

@endsection

@section('sub-content')
    @include('games.partials.edit-buttons', compact('game'))
@endsection
