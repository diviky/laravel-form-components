<?php

namespace Diviky\LaravelFormComponents\Components;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

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
        HtmlString|array|string|Collection|null $extraAttributes = [],
    ) {
        $this->method = strtoupper($method);
        $this->spoofMethod = in_array($this->method, ['PUT', 'PATCH', 'DELETE']);
        $this->style = !is_null($style) ? $style : config('form-components.form_style');

        $this->setExtraAttributes($extraAttributes);
    }
}
