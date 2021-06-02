@if(isset($show) && !!$show)
    <form action="{{ $action }}" method="POST" accept-charset="UTF-8"
          class="inline-block action-form" onsubmit="return confirm('{{ $confirm or 'Tem certeza?' }}');">
        {{ form_fields( $method ) }}

        <button class="btn btn-sm btn-{{ $color }}" title="{{ $label }}">
            <i class="fa fa-fw fa-{{ $icon }}"></i>
            @if(isset($showLabel) && !!$showLabel)
                {{ $label }}
            @endif
        </button>
    </form>
@endif
