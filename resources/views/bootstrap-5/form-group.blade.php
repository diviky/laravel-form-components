<div {!! $attributes->class(['is-invalid' => $hasError($name)]) !!}>
    <x-form-label :label="$label" :required="$attributes->has('required')" :title="$attributes->get('title')" />

    <div @class([
        'd-flex flex-row flex-wrap inline-space' => $inline,
    ])>
        {!! $slot !!}
    </div>

    <x-help> {!! $help ?? null !!} </x-help>

    @if ($hasErrorAndShow($name))
        <x-form-errors :name="$name" class="d-block" />
    @endif
</div>
