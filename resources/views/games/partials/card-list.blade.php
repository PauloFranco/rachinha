<ul class="list-group">
    @forelse($games as $game)
        @include('games.partials.card', compact('game'))
    @empty
        <li class="list-group-item text-center text-muted">
            Use o botão
            @include('games.partials.create-button', [ 'show' => true ])
            para cadastrar o primeiro game.
        </li>
    @endforelse
</ul>
