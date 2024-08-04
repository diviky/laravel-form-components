<div class="mb-3">
    <x-form-label :label="$label" :required="$attributes->has('required')" />

    <div {!! $attributes->merge(['class' => 'input-group' . ($hasError($name) ? ' is-invalid' : '')]) !!}>
        {!! $slot !!}
    </div>

    <x-help> {!! $help ?? null !!} </x-help>

    @if ($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
