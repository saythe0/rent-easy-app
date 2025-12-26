<?php

namespace App\Enums;

use App\Traits\Enums\HasValues;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ProductConditionEnum: string implements HasLabel
{
    use HasValues;

    case NEW = 'new';
    case GOOD = 'good';
    case USED = 'used';


    public function getLabel(): string
    {
        return match ($this) {
            self::NEW => 'Новый',
            self::GOOD => 'Хорошее',
            self::USED => 'Б/у',
        };
    }
}
