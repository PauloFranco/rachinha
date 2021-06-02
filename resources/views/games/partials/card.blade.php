<li class="list-group-item ">
    <div class="row">
        <div class="col-sm-8">
            <h4 class="no-margin-top">{{ date('d/m/Y', strtotime($game->date)) }} <small>{{ $game->size }} jogadores por time </small></h4>

            @include('games.partials.card-content', compact('game'))
        </div>

        <hr class="visible-xs-block mrg-v-10">

        <div class="col-sm-4 text-right no-wrap">
            @include('games.partials.action-buttons', [
                'game'    => $game,
                'showLabel' => false,
                'except'    => [ 'back' ],
            ])
        </div>
    </div>
</li>
