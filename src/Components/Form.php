<?php

namespace Diviky\LaravelFormComponents\Components;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ViewErrorBag;

class Form extends Component
{
    /**
     * Request method.
     */
    public string $method;

    public ?string $style;

    /**
     * Form method spoofing to support PUT, PATCH and DELETE actions.
     * https://laravel.com/docs/master/routing#form-method-spoofing
     */
    public bool $spoofMethod = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $method = 'POST',
        ?string $style = null,
        public bool $hasFiles = false,
        public bool $spellcheck = false,
        public ?array $settings = [],
        HtmlString|array|string|Collection|null $extraAttributes = null,
    ) {
        $this->method = strtoupper($method);
        $this->setExtraAttributes($extraAttributes);

        $this->spoofMethod = in_array($this->method, ['PUT', 'PATCH', 'DELETE']);
        $this->style = !is_null($style) ? $style : config('form-components.form_style');
    }

    /**
     * Returns a boolean wether the error bag is not empty.
     *
     * @param  string  $bag
     */
    public function hasError($bag = 'default'): bool
    {
        $errors = View::shared('errors', fn () => request()->session()->get('errors', new ViewErrorBag));

        return $errors->getBag($bag)->isNotEmpty();
    }
}
