

@if(isset($game))
    @include('common.action-button.view', [
        'action'    => route('games.show', compact('game')),
        'showLabel' => $showLabel,
        'show'      => true,
    ])
@endif




@if(isset($game))
    @include('common.action-button.edit', [
        'action'    => route('games.edit', compact('game')),
        'showLabel' => $showLabel,
        'show'      => true,
    ])
@endif
