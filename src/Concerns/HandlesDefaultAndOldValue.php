<?php

namespace Diviky\LaravelFormComponents\Concerns;

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
}
