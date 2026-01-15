<div @class([
    'form-group' => !$inline,
    'd-none' => $type === 'hidden',
    'position-relative',
    'form-floating' => $floating,
])
    @if ($attributes->has('count')) x-data="{
        charCount: {{ strlen($value ?? '') }},
        maxLength: {{ $attributes->get('count') }},
        updateCount(event) {
            this.charCount = event.target.value.length;
        },
        init() {
            this.updateCharCount();
        },
        updateCharCount() {
            this.$nextTick(() => {
                const input = this.$el.querySelector('input');
                if (input) {
                    this.charCount = input.value.length;
                }
            });
        }
    }"
    x-init="init()" x-effect="updateCharCount()" @endif>

    @if (!$floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$id()" />
    @endif

    <div @class([
        'input-group' =>
            isset($prepend) ||
            isset($append) ||
            isset($before) ||
            isset($after) ||
            $attributes->has('count'),
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
                'name' => $inputName(),
                'id' => $id(),
                'placeholder' => null,
                'value' => $value,
            ])->class([
                'form-control' => true,
                'form-control-color' => $type === 'color',
                'form-control-sm' => $size == 'sm',
                'form-control-lg' => $size == 'lg',
                'is-invalid' => $hasError($inputName()),
            ]) !!} {{ $extraAttributes ?? '' }} {{ $wire() }}
            @if ($attributes->has('count')) @input="updateCount($event)" @endif />

        @isset($append)
            <x-form-input-group-text :attributes="$append->attributes">
                {!! $append !!}
            </x-form-input-group-text>
        @endisset

        @if ($attributes->has('count'))
            <span class="input-group-text">
                <span class="text-muted text-sm" x-text="`${charCount}/${maxLength}`"></span>
            </span>
        @endif

        @isset($after)
            {!! $after !!}
        @endisset
    </div>

    @if ($floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$id()" />
    @endif


    <x-help> {!! $help ?? $attributes->get('help') !!} </x-help>
    <x-form-errors :name="$inputName()" />
</div>
