<div @class([
    'form-check',
    'form-check-inline' => null !== $attributes->get('inline'),
    'm-0' => null !== $attributes->get('compact'),
])>
    <input {!! $attributes->except(['extra-attributes'])->class(['form-check-input', 'is-invalid' => $hasError($inputName())]) !!} type="radio" value="{{ $value }}" {{ $extraAttributes ?? '' }}
        {{ $wire() }} name="{{ $inputName() }}" @if ($label && !$attributes->get('id')) id="{{ $id() }}" @endif
        @checked($checked) />

    <x-form-label :label="$label" :required="$isRequired()" :title="$attributes->get('title')" :for="$id()" class="m-0 form-check-label" />

    <x-help> {!! $help ?? $attributes->get('help') !!} </x-help>
    <x-form-errors :name="$inputName()" />
</div>
