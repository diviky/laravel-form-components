<?php

namespace Diviky\LaravelFormComponents\Components;

use Diviky\LaravelFormComponents\Concerns\HandlesDefaultAndOldValue;
use Diviky\LaravelFormComponents\Concerns\HandlesValidationErrors;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class FormInput extends Component
{
    use HandlesDefaultAndOldValue;
    use HandlesValidationErrors;

    public string $name;

    public string $label;

    public string $type;

    public bool $floating;

    public mixed $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        string $label = '',
        string $type = 'text',
        mixed $bind = null,
        mixed $default = null,
        public ?string $language = null,
        bool $showErrors = true,
        bool $floating = false,
        string|HtmlString|array|Collection|null $extraAttributes = null,
        public ?array $settings = []
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->showErrors = $showErrors;
        $this->floating = $floating && $type !== 'hidden';

        if (!is_null($language)) {
            $this->name = "{$name}[{$language}]";
        }

        $this->setValue($name, $bind, $default, $language);
        $this->setExtraAttributes($extraAttributes);
    }
}
