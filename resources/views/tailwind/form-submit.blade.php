<div class="mt-6 flex items-center justify-between">
    <button {!! $attributes->merge([
        'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-hidden focus:border-gray-900 focus:ring-3 focus:ring-gray-300 disabled:opacity-25 transition',
        'type' => 'submit'
    ]) !!}>
        {!! trim($slot) ?: __('Submit') !!}
    </button>
</div>