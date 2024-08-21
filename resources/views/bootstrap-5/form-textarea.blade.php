<div class="form-group">
    @if ($floating)
        <div class="form-floating">
    @endif

    @if (!$floating)
        <x-form-label :label="$label" :required="$attributes->has('required')" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    <textarea {!! $attributes->except(['extra-attributes'])->merge([
            'class' => 'form-control',
            'name' => $name,
            'id' => $id(),
            'placeholder' => '&nbsp;',
        ])->class([
            'is-invalid' => $hasError($name),
        ]) !!}
        @if ($isWired()) wire:model{!! $wireModifier() !!}="{{ $name }}" @endif
        {{ $extraAttributes ?? '' }}>{!! $value !!}</textarea>

    @if ($floating)
        <x-form-label :label="$label" :required="$attributes->has('required')" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    @if ($floating)
</div>
@endif

<x-help> {!! $help ?? null !!} </x-help>

@if ($hasErrorAndShow($name))
    <x-form-errors :name="$name" />
@endif
</div>
