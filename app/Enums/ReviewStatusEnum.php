<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ReviewStatusEnum: string implements HasLabel
{
    case APPROVED = 'approved';
    case PENDING = 'pending';
    case REJECTED = 'rejected';

    public function getLabel(): string
    {
        return match ($this) {
            self::APPROVED => 'Одобрен',
            self::PENDING => 'В ожидании',
            self::REJECTED => 'Отклонен',
        };
    }
}
