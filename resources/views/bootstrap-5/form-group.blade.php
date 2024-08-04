<div {!! $attributes->merge(['class' => $hasError($name) ? 'is-invalid' : '']) !!}>
    <x-form-label :label="$label" :required="$attributes->has('required')" />

    <div class="@if ($inline) d-flex flex-row flex-wrap inline-space @endif">
        {!! $slot !!}
    </div>

    <x-help> {!! $help ?? null !!} </x-help>

    @if ($hasErrorAndShow($name))
        <x-form-errors :name="$name" class="d-block" />
    @endif
</div>
