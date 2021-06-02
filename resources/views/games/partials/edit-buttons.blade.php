@can('accept', $game)
    <a href="{{ route('games.accept.edit', compact('game')) }}"
       class="btn btn-sm btn-primary"><i class="fa fa-fw fa-thumbs-up"></i> aceitar</a>
@endcan

@can('reject', $game)
    <a href="{{ route('games.reject.edit', compact('game')) }}"
       class="btn btn-sm btn-black"><i class="fa fa-fw fa-thumbs-down"></i> rejeitar e fechar game</a>
@endcan

@can('requestInfo', $game)
    <a href="{{ route('games.request-info.edit', compact('game')) }}"
       class="btn btn-sm btn-warning"><i class="fa fa-fw fa-comment"></i> pedir mais informações</a>
@endcan

@can('addInfo', $game)
    <a href="{{ route('games.add-info.edit', compact('game')) }}"
       class="btn btn-sm btn-info"><i class="fa fa-fw fa-plus"></i> adicionar informação</a>
@endcan

@can('cancel', $game)
    <a href="{{ route('games.cancel.edit', compact('game')) }}"
       class="btn btn-sm btn-danger"><i class="fa fa-fw fa-times"></i> cancelar e fechar game</a>
@endcan

@can('approve', $game)
    <a href="{{ route('games.approve.edit', compact('game')) }}"
       class="btn btn-sm btn-success"><i class="fa fa-fw fa-check"></i> aprovar e fechar game</a>
@endcan

@can('markAsDone', $game)
    <a href="{{ route('games.mark-as-done.edit', compact('game')) }}"
       class="btn btn-sm btn-primary"><i class="fa fa-fw fa-check-square-o"></i> concluir e fechar game</a>
@endcan

@can('reopen', $game)
    <a href="{{ route('games.reopen.edit', compact('game')) }}"
       class="btn btn-sm btn-purple"><i class="fa fa-fw fa-refresh"></i> reabrir</a>
@endcan
