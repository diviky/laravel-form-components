<div @class([
    'd-inline' => null !== $attributes->get('inline'),
])>
    @if ($attributes->has('title'))
        <div class="mb-2 text-bold">{{ $attributes->get('title') }}</div>
    @endif

    <div @class([
        'form-check',
        'form-check-inline' => null !== $attributes->get('inline'),
        'm-0' => null !== $attributes->get('compact'),
    ])>
        @if ($copy !== false)
            <input type="hidden" value="{{ $copy }}" name="{{ $name }}" />
        @endif

        <input {!! $attributes->except(['extra-attributes'])->class([
                'is-invalid' => $hasError($name),
                'form-check-input',
            ])->merge([
                'id' => $id(),
                'name' => $name,
                'type' => 'checkbox',
                'value' => $value,
            ]) !!} {{ $extraAttributes ?? '' }} {{ $wire() }} @checked($checked) />

        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()"
            @class(['form-check-label', 'm-0']) />

        <span class="form-check-description">
            <x-help> {!! $help ?? $attributes->get('help') !!} </x-help>
        </span>
    </div>

    <x-form-errors :name="$name" />
</div>
