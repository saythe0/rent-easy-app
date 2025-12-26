<?php

namespace App\Filament\Resources\PostCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PostCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(self::getComponents());
    }

    public static function getComponents(): array
    {
        return [
            TextInput::make('name')
                ->label('Название')
                ->maxLength(255)
                ->required(),
        ];
    }
}
