<div class="form-group position-relative">
    @if ($floating)
        <div class="form-floating">
    @endif

    @if (!$floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    @isset($before)
        {!! $before !!}
    @endisset

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

    @isset($after)
        {!! $after !!}
    @endisset

    @if ($floating)
</div>
@endif

<x-help> {!! $help ?? $attributes->get('help') !!} </x-help>
<x-form-errors :name="$name" />
</div>
