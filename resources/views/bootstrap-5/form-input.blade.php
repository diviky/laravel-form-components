<div class="form-group @if ($type === 'hidden') d-none @endif">
    @if ($floating)
        <div class="form-floating">
    @endif

    @if (!$floating)
        <x-form-label :label="$label" :required="$attributes->has('required')" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    <div @class([
        'input-group' => isset($prepend) || isset($append),
        'input-icon' => @isset($icon),
        'input-group-flat' => $attributes->has('flat'),
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
                'class' => 'form-control',
                'type' => $type,
                'name' => $name,
                'id' => $id(),
                'placeholder' => null,
                'value' => $value,
            ])->class([
                'form-control-color' => $type === 'color',
                'is-invalid' => $hasError($name),
            ]) !!} {{ $extraAttributes ?? '' }}
            @if ($isWired()) wire:model{!! $wireModifier() !!}="{{ $name }}" @endif />

        @isset($append)
            <x-form-input-group-text :attributes="$append->attributes">
                {!! $append !!}
            </x-form-input-group-text>
        @endisset
    </div>
    @if ($floating)
        <x-form-label :label="$label" :required="$attributes->has('required')" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    @if ($floating)
</div>
@endif

<x-help> {!! $help ?? null !!} </x-help>
<x-form-errors :name="$name" />

</div>
