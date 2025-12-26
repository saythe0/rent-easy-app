<?php

namespace App\Traits\Enums;

use Illuminate\Support\Collection;

trait HasValues
{
    public static function values(): Collection
    {
        return collect(self::cases())->map(function ($enum): array {
            return [
                'value' => $enum->value,
                'label' => $enum->getLabel(),
            ];
        });
    }
}
