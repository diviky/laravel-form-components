<div @class([
    'form-group' => !$inline,
    'd-none' => $type === 'hidden',
    'position-relative',
    'form-floating' => $floating,
])
    @if ($attributes->has('length')) x-data="{
        charCount: {{ strlen($value ?? '') }},
        maxLength: {{ $attributes->get('length') }},
        updateCount(event) {
            this.charCount = event.target.value.length;
        }
    }"
    x-init="charCount = $el.querySelector('input')?.value?.length || 0" @endif>

    @if (!$floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    <div @class([
        'input-group' =>
            isset($prepend) || isset($append) || isset($before) || isset($after),
        'input-icon' =>
            @isset($icon) || $attributes->has('icon'),
        'input-group-flat' => $attributes->has('flat'),
        'input-group-sm' => (isset($prepend) || isset($append)) && $size == 'sm',
        'input-group-lg' => (isset($prepend) || isset($append)) && $size == 'lg',
    ])>

        @isset($prepend)
            <x-form-input-group-text :attributes="$prepend->attributes">
                {!! $prepend !!}
            </x-form-input-group-text>
        @endisset

        @isset($before)
            {!! $before !!}
        @endisset

        @isset($icon)
            <span class="input-icon-addon">
                <x-icon :name="$icon" />
            </span>
        @endisset

        @if ($attributes->has('icon'))
            <span class="input-icon-addon">
                <x-icon :name="$attributes->get('icon')" />
            </span>
        @endif

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
            ]) !!} {{ $extraAttributes ?? '' }} {{ $wire() }}
            @if ($attributes->has('length')) @input="updateCount($event)" @endif />

        @isset($append)
            <x-form-input-group-text :attributes="$append->attributes">
                {!! $append !!}
            </x-form-input-group-text>
        @endisset

        @if ($attributes->has('length'))
            <span class="input-group-text">
                <span class="text-muted text-sm" x-text="`${charCount}/${maxLength}`"></span>
            </span>
        @endif

        @isset($after)
            {!! $after !!}
        @endisset
    </div>

    @if ($floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif


    <x-help> {!! $help ?? $attributes->get('help') !!} </x-help>
    <x-form-errors :name="$name" />
</div>
