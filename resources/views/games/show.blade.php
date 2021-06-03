@extends('layouts.app')


@section('content')
<div class="mrg-bottom-15">
    <h4 class="no-margin-bottom">{{ $game->present()->date }}</h4>

</div>
<h1 class="no-margin-bottom">{{ $game->present()->size }}</h1>


<p>{{ $game->present()->confirmation }}</p>
@endsection

@section('sub-content')
    @include('games.partials.edit-buttons', compact('game'))
@endsection
