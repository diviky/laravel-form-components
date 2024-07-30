@if ($label)
    <label {!! $attributes->merge(['class' => 'form-label']) !!}>
        <span>
            {{ $label }}

            @if ($required)
                <span class="text-warning">*</span>
            @endif
        </span>
    </label>
@endif
