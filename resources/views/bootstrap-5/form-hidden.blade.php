<input {!! $attributes->except(['extra-attributes'])->merge([
        'type' => 'hidden',
        'name' => $name(),
        'id' => $id(),
        'placeholder' => null,
        'value' => $value,
    ])->class([
        'form-control' => true,
        'form-control-color' => $type === 'color',
        'form-control-sm' => $size == 'sm',
        'form-control-lg' => $size == 'lg',
        'is-invalid' => $hasError($name()),
    ]) !!} {{ $extraAttributes ?? '' }} {{ $wire() }} />
