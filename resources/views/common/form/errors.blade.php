@if ($errors->has($field))
    <span class="help-block">
        <strong class="text-danger">{{ $errors->first($field) }}</strong>
    </span>
@endif
