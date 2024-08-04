<div class="form-check @if (null !== $attributes->get('inline')) form-check-inline @endif">

    @isset($copy)
        <input type="hidden" value="{{ $copy }}" name="{{ $name }}" />
    @endisset

    <input {!! $attributes->except(['extra-attributes'])->class([
            'is-invalid' => $hasError($name),
        ])->merge([
            'class' => 'form-check-input',
            'id' => $id(),
            'name' => $name,
            'type' => 'checkbox',
            'value' => $value,
        ]) !!} {{ $extraAttributes ?? '' }}
        @if ($isWired()) wire:model{!! $wireModifier() !!}="{{ $name }}" @endif
        @checked($checked) />

    <x-form-label :label="$label" :required="$attributes->has('required')" :for="$attributes->get('id') ?: $id()" class="form-check-label" />

    <x-help> {!! $help ?? null !!} </x-help>

    @if ($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
