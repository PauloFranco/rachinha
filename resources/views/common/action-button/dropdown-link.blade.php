@if(isset($show) && !!$show)
    <div class="dropdown pull-right">
        <button type="button" class="btn btn-sm btn-{{ $color }} dropdown-toggle" title="{{ $label }}"
                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @unless($icon === false)
                <i class="fa fa-fw fa-{{ $icon }}"></i>
            @endunless


            @if(isset($showLabel) && !!$showLabel)
                {{ $label }}
            @endif
        </button>
        <ul class="dropdown-menu">
            @foreach($comandos as $comando)
                <li><a class="dropdown-item"
                       href="{{route('controle-de-projetos.store', [$comando->id])}}">{{$comando->nome}}</a></li>
            @endforeach
        </ul>
    </div>
@endif
