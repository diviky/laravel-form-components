@if ($label)
    <label {!! $attributes->merge(['class' => 'form-label']) !!}>
        <span
            @if ($attributes->has('title')) class="text-underline" data-toggle="tooltip" title="{{ $attributes->get('title') }}" @endif>
            {{ $label }}

            @if ($required)
                <span class="text-warning">*</span>
            @endif
        </span>
    </label>
@endif
