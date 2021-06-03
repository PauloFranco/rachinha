<ul class="list-group">
    @forelse($users as $user)
        @include('users.partials.card', compact('user'))
    @empty
        <li class="list-group-item text-center text-muted">
            Use o botão
            @include('users.partials.create-button', [ 'show' => true ])
            para cadastrar o primeiro usuário.
        </li>
    @endforelse
</ul>
