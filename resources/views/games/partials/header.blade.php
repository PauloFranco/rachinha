<div class="page-header clearfix">
    <div class="pull-right">
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
