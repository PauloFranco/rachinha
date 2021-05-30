@extends('layouts.app')

@section('title', make_title('Novo usuário'))

@section('header')

@endsection


@section('content')
    <div class="tab-content">
        <div class="tab-pane active" id="info">
            <form action="{{ route('users.store') }}" method="POST" accept-charset="UTF-8">
                {{ form_fields( 'POST' ) }}

                @include('users.partials.form', compact('user'))

                <hr>
                <p class="text-right">
                    <a href="{{ route('home')  }}" tabindex="-1"
                       class="btn btn-link">cancelar</a>

                    <button class="btn btn-success"><i class="fa fa-fw fa-plus"></i> criar</button>
                </p>
            </form>
        </div>
    </div>
@endsection