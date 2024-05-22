<button {!! $attributes->merge([
        'class' => 'btn btn-primary',
        'type' => 'submit',
    ])->class(['btn-block' => $attributes->has('block')]) !!}>
    {!! trim($slot) ?: __('Submit') !!}
</button>
