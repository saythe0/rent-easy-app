<?php

namespace App\Enums;

use App\Traits\Enums\HasValues;
use Filament\Support\Contracts\HasLabel;

enum ProductStatusEnum: string implements HasLabel
{
    case AVAILABLE = 'available';
    case RENTED = 'rented';

    public function getLabel(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Доступен',
            self::RENTED => 'В аренде',
        };
    }
}
