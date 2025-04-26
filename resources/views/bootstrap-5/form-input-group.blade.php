<div class="mb-3">
    <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" />

    <div {!! $attributes->class(['input-group', 'is-invalid' => $hasError($name)]) !!}>
        {!! $slot !!}
    </div>

    <x-help> {!! $help ?? $attributes->get('help') !!} </x-help>

    @if ($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
