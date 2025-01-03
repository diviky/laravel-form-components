<div class="mb-3">
    <x-form-label :label="$label" :required="$attributes->has('required')" :title="$attributes->get('title')" />

    <div {!! $attributes->class(['input-group', 'is-invalid' => $hasError($name)]) !!}>
        {!! $slot !!}
    </div>

    <x-help> {!! $help ?? null !!} </x-help>

    @if ($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
