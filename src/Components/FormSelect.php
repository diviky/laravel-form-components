<?php

namespace Diviky\LaravelFormComponents\Components;

use Diviky\LaravelFormComponents\Concerns\GetsSelectOptionProperties;
use Diviky\LaravelFormComponents\Concerns\HandlesBoundValues;
use Diviky\LaravelFormComponents\Concerns\HandlesValidationErrors;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class FormSelect extends Component
{
    use GetsSelectOptionProperties;
    use HandlesBoundValues;
    use HandlesValidationErrors;

    public string $name;

    public string $label;

    public array|Collection $options;

    public $selectedKey;

    public bool $multiple;

    public bool $floating;

    public string $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $label = '',
        $options = [],
        $bind = null,
        $default = null,
        bool $multiple = false,
        bool $showErrors = true,
        bool $floating = false,
        string $placeholder = '',
        public ?string $valueField = null,
        public ?string $labelField = null,
        public ?string $disabledField = null,
        public ?string $childrenField = null,
        string|HtmlString|array|Collection|null $extraAttributes = null,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->placeholder = $placeholder;
        $this->setExtraAttributes($extraAttributes);

        if ($this->isNotWired()) {
            $inputName = static::convertBracketsToDots(Str::before($name, '[]'));

            if (is_null($default)) {
                $default = $this->getBoundValue($bind, $inputName);
            }

            $this->selectedKey = old($inputName, $default);

            if ($this->selectedKey instanceof Arrayable) {
                $this->selectedKey = $this->selectedKey->toArray();
            }
        }

        $this->multiple = $multiple;
        $this->showErrors = $showErrors;
        $this->floating = $floating && !$multiple;

        $this->valueField = $valueField ?? 'id';
        $this->labelField = $labelField ?? 'name';
        $this->disabledField = $disabledField ?? 'disabled';
        $this->childrenField = $childrenField ?? 'children';

        $this->options = $this->normalizeOptions($options);
    }

    public function isSelected($key): bool
    {
        if ($this->isWired()) {
            return false;
        }

        return in_array($key, Arr::wrap($this->selectedKey));
    }

    public function nothingSelected(): bool
    {
        if ($this->isWired()) {
            return false;
        }

        return is_array($this->selectedKey) ? empty($this->selectedKey) : is_null($this->selectedKey);
    }

    protected function normalizeOptions(array|Collection $options): Collection
    {
        return collect($options)
            ->map(function ($value, $key) {
                // If the key is not numeric, we're going to assume this is the value.
                if (!is_numeric($key)) {
                    return [
                        $this->valueField => $key,
                        $this->labelField => $value,
                    ];
                }

                // If the value is a simple value, we need to convert it to an array.
                if (!is_iterable($value) && !$value instanceof Model) {
                    return [
                        $this->valueField => $value,
                        $this->labelField => $value,
                    ];
                }

                return $value;
            });
    }
}
