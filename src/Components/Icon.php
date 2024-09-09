<?php

declare(strict_types=1);

namespace Diviky\LaravelFormComponents\Components;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class Icon extends Component
{
    public function __construct(
        public ?string $name = null,
        public ?string $label = null,
        public ?string $action = null,
        public ?string $size = null
    ) {}

    public function icon(): string|Stringable
    {
        if (empty($this->name)) {
            return '';
        }

        $name = Str::of($this->name);

        return $name->contains('.') ? $name->replace('.', '-') : "ti ti-{$this->name}";
    }

    public function labelClasses(): mixed
    {
        // Remove `w-*` and `h-*` classes, because it applies only for icon
        return Str::replaceMatches('/(w-\w*)|(h-\w*)/', '', $this->attributes->get('class') ?? '');
    }
}
