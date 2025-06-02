<?php

namespace Diviky\LaravelFormComponents\Components;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class FormRadio extends Component
{
    public string $label;

    public mixed $value;

    public bool $checked = false;

    public function __construct(
        string $name = '',
        string $label = '',
        mixed $value = 1,
        mixed $bind = null,
        string $bindKey = '',
        ?bool $default = false,
        bool $showErrors = false,
        public ?array $settings = [],
        string|HtmlString|array|Collection|null $extraAttributes = null,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->showErrors = $showErrors;

        $this->setExtraAttributes($extraAttributes);

        $inputName = static::convertBracketsToDots($name);

        if (old($inputName) !== null) {
            $this->checked = old($inputName) == $value;
        }

        if (!session()->hasOldInput() && $this->isNotWired()) {
            $boundValue = $this->getBoundValue($bind, $inputName, $bindKey);

            if (!is_null($boundValue)) {
                $this->checked = $boundValue == $this->value;
            } else {
                $this->checked = boolval($default);
            }
        }
    }

    /**
     * Generates an ID by the name and value attributes.
     */
    #[\Override]
    protected function generateIdByName(): string
    {
        return 'auto_id_' . $this->name . '_' . $this->value;
    }
}
