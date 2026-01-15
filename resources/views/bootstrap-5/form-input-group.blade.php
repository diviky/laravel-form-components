<div class="mb-3">
    <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" />

    <div {!! $attributes->class(['input-group', 'is-invalid' => $hasError($inputName())]) !!}>
        {!! $slot !!}
    </div>

    <x-help> {!! $help ?? $attributes->get('help') !!} </x-help>
    <x-form-errors :name="$inputName()" />
</div>
