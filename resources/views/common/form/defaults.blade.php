{{ csrf_field() }}

@unless(in_array($method, ['GET', 'POST']))
    {{ method_field($method) }}
@endunless
