<?php

namespace Diviky\LaravelFormComponents\Components;

use Diviky\LaravelFormComponents\Concerns\HandlesBoundValues;
use Diviky\LaravelFormComponents\Concerns\HandlesValidationErrors;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class FormCheckbox extends Component
{
    use HandlesBoundValues;
    use HandlesValidationErrors;

    public string $name;

    public string $label;

    public mixed $value;

    public bool $checked = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        string $label = '',
        mixed $value = 1,
        mixed $bind = null,
        bool $default = false,
        bool $showErrors = true,
        public mixed $copy = '0',
        // Extra attributes
        HtmlString|array|string|Collection|null $extraAttributes = null,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->showErrors = $showErrors;
        $this->copy = $copy;

        $this->setExtraAttributes($extraAttributes);

        $inputName = static::convertBracketsToDots(Str::before($name, '[]'));

        if ($oldData = old($inputName)) {
            $this->checked = in_array($value, Arr::wrap($oldData));
        }

        if (!session()->hasOldInput() && $this->isNotWired()) {
            $boundValue = $this->getBoundValue($bind, $inputName);

            if ($boundValue instanceof Arrayable) {
                $boundValue = $boundValue->toArray();
            }

            if (is_array($boundValue)) {
                $this->checked = in_array($value, $boundValue);

                return;
            }

            $this->checked = is_null($boundValue) ? $default : ($boundValue == $value);
        }
    }

    /**
     * Generates an ID by the name and value attributes.
     */
    protected function generateIdByName(): string
    {
        return 'auto_id_' . $this->name . '_' . $this->value;
    }
}
