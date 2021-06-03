<p class="no-margin">Jogadores confirmados:</p>

<p class="no-margin-bottom text-muted">
    @foreach($game->users as $user)
    <p>
        <small class="pad-right-15 no-padding--empty">{{$user->name}}</small>
        @if($user->goalkeeper)
            <small class="pad-right-15"> - goleiro</small>
        @else
            <small class="pad-right-15"> - linha</small>
        @endif
    </p>
    @endforeach
</p>
