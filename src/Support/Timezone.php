<?php

declare(strict_types=1);

namespace Diviky\LaravelFormComponents\Support;

use DateTime;
use DateTimeZone;

class Timezone
{
    protected static array $generalTimezones = [
        'GMT' => 'GMT',
        'UTC' => 'UTC',
    ];

    protected static array $regions = [
        'Africa' => DateTimeZone::AFRICA,
        'America' => DateTimeZone::AMERICA,
        'Antarctica' => DateTimeZone::ANTARCTICA,
        'Arctic' => DateTimeZone::ARCTIC,
        'Asia' => DateTimeZone::ASIA,
        'Atlantic' => DateTimeZone::ATLANTIC,
        'Australia' => DateTimeZone::AUSTRALIA,
        'Europe' => DateTimeZone::EUROPE,
        'Indian' => DateTimeZone::INDIAN,
        'Pacific' => DateTimeZone::PACIFIC,
    ];

    /*
     * Specify a subset of regions to return.
     */
    protected bool|array|string|null $only;

    protected array $timezones;

    public function only(array|string|bool|null $only): self
    {
        if (is_string($only)) {
            $only = [$only];
        }

        $this->only = $only;

        return $this;
    }

    /**
     * @deprecated Use allMapped() instead.
     */
    public function all(): array
    {
        if (!empty($this->timezones) && $this->only === false) {
            return $this->timezones;
        }

        $timezones = [];

        if ($this->shouldIncludeRegion('General')) {
            $timezones['General'] = self::$generalTimezones;
        }

        foreach ($this->regionsToInclude() as $region => $regionCode) {
            $regionTimezones = DateTimeZone::listIdentifiers($regionCode);
            $timezones[$region] = [];

            foreach ($regionTimezones as $timezone) {
                $format = $this->format($timezone);

                if ($format === false) {
                    continue;
                }

                $timezones[$region][$timezone] = $format;
            }
        }

        // reset to default options
        $this->only = false;

        return $this->timezones = $timezones;
    }

    /**
     * Return the requested timezones but mapped to be compatible with our selects.
     *
     * @version 8.0.0
     */
    public function allMapped(): array
    {
        if (!empty($this->timezones) && $this->only === false) {
            return $this->timezones;
        }

        $timezones = [];

        if ($this->shouldIncludeRegion('General')) {
            $timezones[] = [
                'id' => 'General',
                'name' => 'General',
                'children' => array_values(array_map(function ($timezone) {
                    return [
                        'id' => $timezone,
                        'name' => $timezone,
                    ];
                }, self::$generalTimezones)),
            ];
        }

        foreach ($this->regionsToInclude() as $region => $regionCode) {
            $regionTimezones = DateTimeZone::listIdentifiers($regionCode);
            $model = [
                'id' => $region,
                'name' => $region,
                'children' => [],
            ];

            foreach ($regionTimezones as $timezone) {
                $format = $this->format($timezone);

                if ($format === false) {
                    continue;
                }

                $model['children'][] = [
                    'id' => $timezone,
                    'name' => $format,
                ];
            }

            $timezones[] = $model;
        }

        // Reset to default options.
        $this->only = false;

        return $this->timezones = $timezones;
    }

    protected function format(string $timezone): bool|string
    {
        $time = new DateTime('', new DateTimeZone($timezone));
        $offset = $this->normalizeOffset($timezone, $time->format('P'));

        if ($offset === false) {
            return false;
        }

        $timezone = str_replace(
            ['St_', '_'],
            ['St.', ' '],
            $timezone
        );

        return "(GMT/UTC {$offset}) {$timezone}";
    }

    /**
     * This is only here because automated tests are returning different
     * timezone offsets for certain timezones than when tests are
     * ran locally. This may need to be addressed in the future...
     */
    private function normalizeOffset(string $timezone, $offset): bool|string
    {
        return match ($timezone) {
            'Africa/Juba' => '+02:00',
            'Europe/Volgograd' => '+03:00',
            'Australia/Currie' => false,
            default => $offset,
        };
    }

    protected function regionsToInclude(): array
    {
        if ($this->only === false) {
            return self::$regions;
        }

        return array_filter(self::$regions, fn ($region) => $this->shouldIncludeRegion($region), ARRAY_FILTER_USE_KEY);
    }

    protected function shouldIncludeRegion(string $region): bool
    {
        if ($this->only === false) {
            return true;
        }

        return in_array($region, $this->only, true);
    }
}
