<?php

namespace Diviky\LaravelFormComponents\Components;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class FormInput extends Component
{
    public string $label;

    public mixed $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        string $label = '',
        public string $type = 'text',
        public string $size = '',
        mixed $bind = null,
        string $bindKey = '',
        public mixed $default = null,
        public ?string $language = null,
        bool $showErrors = true,
        public bool $floating = false,
        public bool $inline = false,
        string|HtmlString|array|Collection|null $extraAttributes = null,
        public ?array $settings = [],
        public mixed $enabled = true,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->showErrors = $showErrors;
        $this->floating = $floating && $type !== 'hidden';

        if (!is_null($language)) {
            $this->name = "{$name}[{$language}]";
        }

        $this->setValue($name, $bind, $default, $language, $bindKey);
        $this->setExtraAttributes($extraAttributes);

        if (is_array($this->value)) {
            $this->value = json_encode($this->value);
        }
    }
}
