<?php

namespace Diviky\LaravelFormComponents\Components;

use Diviky\LaravelFormComponents\Concerns\GetsSelectOptionProperties;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class FormSelect extends Component
{
    use GetsSelectOptionProperties;

    public string $name;

    public string $label;

    public array|Collection|null $options;

    public mixed $value;

    public bool $multiple;

    public bool $floating;

    public string $values;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = '',
        string $label = '',
        array|Collection|null $options = [],
        mixed $bind = null,
        mixed $default = null,
        bool $multiple = false,
        bool $showErrors = true,
        bool $floating = false,
        public bool $inline = false,
        public string $placeholder = '',
        public string $size = '',
        public ?string $valueField = null,
        public ?string $labelField = null,
        public ?string $disabledField = null,
        public ?string $childrenField = null,
        public ?array $settings = [],
        string|HtmlString|array|Collection|null $extraAttributes = null,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->setExtraAttributes($extraAttributes);

        if ($this->isNotWired()) {
            $inputName = static::convertBracketsToDots($name);

            if (is_null($default)) {
                $default = $this->getBoundValue($bind, $inputName);
            }

            $this->value = old($inputName, $default);

            if ($this->value instanceof Arrayable) {
                $this->value = $this->value->toArray();
            }
        }

        $this->values = implode(',', Arr::wrap($this->value));
        $this->multiple = $multiple;
        $this->showErrors = $showErrors;
        $this->floating = $floating && !$multiple;

        $this->valueField = $valueField ?? ((is_array($extraAttributes) && isset($extraAttributes['value-field'])) ? $extraAttributes['value-field'] : 'id');
        $this->labelField = $labelField ?? ((is_array($extraAttributes) && isset($extraAttributes['label-field'])) ? $extraAttributes['label-field'] : 'text');
        $this->disabledField = $disabledField ?? 'disabled';
        $this->childrenField = $childrenField ?? 'children';

        $this->options = $this->normalizeOptions($options);
    }

    public function isSelected($key): bool
    {
        if ($this->isWired()) {
            return false;
        }

        return in_array($key, Arr::wrap($this->value));
    }

    public function nothingSelected(): bool
    {
        if ($this->isWired()) {
            return false;
        }

        return is_array($this->value) ? empty($this->value) : is_null($this->value);
    }

    protected function normalizeOptions(array|Collection|null $options): Collection
    {
        if (is_null($options)) {
            return collect([]);
        }

        if (!is_array($options)) {
            $options = $options->toArray();
        }

        $isList = Arr::isList($options);

        return collect($options)
            ->map(function ($value, $key) use ($isList) {
                // If the key is not numeric, we're going to assume this is the value.
                if (!is_numeric($key) || !$isList) {
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
