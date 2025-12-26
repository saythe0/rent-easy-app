<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ApplicationStatusEnum: string implements HasLabel
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case RETURNED = 'returned';
    case CANCELED = 'canceled';
    case CANCELED_BY_USER = 'canceled_by_user';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'В ожидании',
            self::ACTIVE => 'Активно',
            self::RETURNED => 'Возвращено',
            self::CANCELED => 'Отменено',
            self::CANCELED_BY_USER => 'Отменено пользователем',
        };
    }
}
