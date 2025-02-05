<div class="form-group">
    @if ($floating)
        <div class="form-floating">
    @endif

    @if (!$floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    <textarea {!! $attributes->except(['extra-attributes'])->merge([
            'name' => $name,
            'id' => $id(),
            'placeholder' => '',
        ])->class([
            'form-control' => true,
            'form-control-color' => $type === 'color',
            'form-control-sm' => $size == 'sm',
            'form-control-lg' => $size == 'lg',
            'is-invalid' => $hasError($name),
        ]) !!} {{ $wire() }} {{ $extraAttributes ?? '' }}>{!! $value !!}</textarea>

    @if ($floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    @if ($floating)
</div>
@endif

<x-help> {!! $help ?? null !!} </x-help>

@if ($hasErrorAndShow($name))
    <x-form-errors :name="$name" />
@endif
</div>
