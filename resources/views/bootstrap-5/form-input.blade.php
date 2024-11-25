<div @class([
    'form-group' => !$inline,
    'd-none' => $type === 'hidden',
    'form-floating' => $floating,
])>
    @if (!$floating)
        <x-form-label :label="$label" :required="$attributes->has('required')" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    <div @class([
        'input-group' => isset($prepend) || isset($append),
        'input-icon' => @isset($icon),
        'input-group-flat' => $attributes->has('flat'),
        'input-group-sm' => (isset($prepend) || isset($append)) && $size == 'sm',
        'input-group-lg' => (isset($prepend) || isset($append)) && $size == 'lg',
    ])>

        @isset($prepend)
            <x-form-input-group-text :attributes="$prepend->attributes">
                {!! $prepend !!}
            </x-form-input-group-text>
        @endisset

        @isset($icon)
            <span class="input-icon-addon">
                {!! $icon !!}
            </span>
        @endisset

        <input {!! $attributes->except(['extra-attributes'])->merge([
                'type' => $type,
                'name' => $name,
                'id' => $id(),
                'placeholder' => null,
                'value' => $value,
            ])->class([
                'form-control' => true,
                'form-control-color' => $type === 'color',
                'form-control-sm' => $size == 'sm',
                'form-control-lg' => $size == 'lg',
                'is-invalid' => $hasError($name),
            ]) !!} {{ $extraAttributes ?? '' }} {{ $wire() }} />

        @isset($append)
            <x-form-input-group-text :attributes="$append->attributes">
                {!! $append !!}
            </x-form-input-group-text>
        @endisset
    </div>
    @if ($floating)
        <x-form-label :label="$label" :required="$attributes->has('required')" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    <x-help> {!! $help ?? null !!} </x-help>
    <x-form-errors :name="$name" />
</div>
