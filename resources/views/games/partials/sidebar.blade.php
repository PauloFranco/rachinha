<div class="mrg-bottom-15">
    <h4 class="no-margin-bottom">{{ $ticket->present()->subject }}</h4>
    <p class="no-margin-top">{{ $ticket->present()->due_at }}</p>

    <p><strong>Aceito por</strong> {{ $ticket->manager->present()->link }}</p>
    <p><strong>Responsável</strong> {{ $ticket->responsible->present()->link }}</p>
</div>

@if($showOpeningEvent)
    <div class="mrg-bottom-15">
        @include('tickets.ticket.partials.events', [
            'events'     => [ $ticket->openEvent ],
            'showStatus' => false,
        ])
    </div>
@endif

<div class="mrg-bottom-15 clearfix">
    <div class="pull-right">
        @include('common.action-button.add', [
            'action' => route('tickets.attachments.create', compact('ticket')),
            'show'   => $authUser->can('attach-to', $ticket) && $showAddAttachmentButton,
        ])
    </div>

    <h4>Anexos <small>máx. 3</small></h4>

    @include('tickets.ticket.partials.attachments', compact('ticket'))
</div>

@if($history->isNotEmpty())
    <div class="mrg-bottom-15">
        <h4>
            Histórico recente
            @if($totalEvents > 5)
                <small><a href="{{ route('tickets.history', compact('ticket')) }}">ver todos</a></small>
            @endif
        </h4>

        @include('tickets.ticket.partials.events', [ 'events' => $history ])
    </div>
@endif
