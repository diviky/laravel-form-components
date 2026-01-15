<?php

namespace Diviky\LaravelFormComponents\Concerns;

use Illuminate\View\ComponentAttributeBag;

trait HandlesDefaultAndOldValue
{
    protected function setValue(
        string $name,
        mixed $bind = null,
        mixed $default = null,
        ?string $language = null,
        ?string $bindKey = null
    ): void {
        if ($this->isWired()) {
            return;
        }

        $inputName = static::convertBracketsToDots($name);

        if (!$language) {
            $boundValue = $this->getBoundValue($bind, $inputName, $bindKey);

            $default = is_null($boundValue) ? $default : $boundValue;

            $this->value = old($inputName, $default);

            return;
        }

        if ($bind !== false) {
            $bind = $bind ?: $this->getBoundTarget();
        }

        if ($bind) {
            $default = $bind->getTranslation($name, $language, false) ?: $default;
        }

        $this->value = old("{$inputName}.{$language}", $default);
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    protected function setName(string $name = '', ?string $language = null, $wired = false): string
    {
        if (!empty($name) && !$wired) {
            return $name;
        }

        $name = $this->getWireName($this->attributes);
        $name = static::convertDotsToBrackets($name);
        $this->name = $name;

        if (!is_null($language)) {
            $this->name = "{$name}[{$language}]";
        }

        return $this->name;
    }

    protected function getWireName(ComponentAttributeBag $attributes): string
    {
        $wireAttributes = $attributes->whereStartsWith('wire:model')->getAttributes();

        if (empty($wireAttributes)) {
            return '';
        }

        // Get the first wire:model attribute value
        $firstAttribute = reset($wireAttributes);

        return $firstAttribute;
    }

    /**
     * Converts a dotted-notation to a bracket-notation
     */
    protected static function convertDotsToBrackets(string $name): string
    {
        return preg_replace('/\.(\w+)/', '[$1]', $name);
    }

    public function name(): string
    {
        return $this->setName($this->name, $this->language ?? null, $this->isWired());
    }
}
