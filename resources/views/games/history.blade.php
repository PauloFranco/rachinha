@extends('tickets.ticket.partials.layout')

@section('sub-content')
    <h4>Histórico completo</h4>

    @include('tickets.ticket.partials.events', ['events' => $ticket->events])
@endsection
