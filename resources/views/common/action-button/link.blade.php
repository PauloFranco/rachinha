@if(isset($show) && !!$show)
    <a href="{{ $action }}" class="btn btn-sm btn-{{ $color }}" title="{{ $label }}">
        @unless($icon === false)
            <i class="fa fa-fw fa-{{ $icon }}"></i>
        @endunless

        @if(isset($showLabel) && !!$showLabel)
            {{ $label }}
        @endif
    </a>
@endif
