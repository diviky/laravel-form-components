<?php

namespace Diviky\LaravelFormComponents\Concerns;

trait HandlesDefaultAndOldValue
{
    use HandlesBoundValues;

    protected function setValue(
        string $name,
        mixed $bind = null,
        mixed $default = null,
        ?string $language = null
    ): void {
        if ($this->isWired()) {
            return;
        }

        $inputName = static::convertBracketsToDots($name);

        if (!$language) {
            $boundValue = $this->getBoundValue($bind, $inputName);

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
}
