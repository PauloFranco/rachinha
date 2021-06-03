<div class="page-header clearfix">

    <div class="pull-right">
        <a class="btn btn-info" href="{{route('games.index')}}" style="float:right" role="button">Partidas</a>

        @include('users.partials.action-buttons', [
            'user'    => $user,
            'showLabel' => true,
            'except'    => $except,
        ])
    </div>

    <h1>
        {{ $title }}
    </h1>
</div>
