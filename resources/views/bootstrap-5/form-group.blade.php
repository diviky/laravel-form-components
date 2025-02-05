<div
    {{ $attributes->only(['class'])->class([
        'form-group' => !$inline,
        'form-floating' => $floating,
        'is-invalid' => $hasError($name),
    ]) }}>
    @if (!$floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    <div @class([
        'd-flex flex-row flex-wrap inline-space' => $inline,
    ])>
        {!! $slot !!}
    </div>

    @if ($floating)
        <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$attributes->get('id') ?: $id()" />
    @endif

    <x-help> {!! $help ?? null !!} </x-help>
    <x-form-errors :name="$name" />
</div>
