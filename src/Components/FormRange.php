<?php

namespace Diviky\LaravelFormComponents\Components;

use Diviky\LaravelFormComponents\Concerns\HandlesDefaultAndOldValue;
use Diviky\LaravelFormComponents\Concerns\HandlesValidationErrors;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class FormRange extends Component
{
    use HandlesDefaultAndOldValue;
    use HandlesValidationErrors;

    public string $name;

    public string $label;

    public mixed $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $label = '',
        mixed $bind = null,
        mixed $default = null,
        ?string $language = null,
        bool $showErrors = true,
        string|HtmlString|array|Collection|null $extraAttributes = null,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->showErrors = $showErrors;
        $this->setExtraAttributes($extraAttributes);

        if ($language) {
            $this->name = "{$name}[{$language}]";
        }

        $this->setValue($name, $bind, $default, $language);
    }
}
