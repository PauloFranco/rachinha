<div class="page-header clearfix">
    <div class="pull-right">
        <a class="btn btn-info" href="{{route('users.index')}}" style="float:right" role="button">Jogadores</a>

        @include('games.partials.action-buttons', [
            'game'    => $game,
            'showLabel' => true,
            'except'    => $except,
        ])
    </div>

    <h1>
        {{ $title }}
    </h1>
</div>
