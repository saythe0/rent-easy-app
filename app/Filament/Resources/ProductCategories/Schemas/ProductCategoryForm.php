<?php

namespace App\Filament\Resources\ProductCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductCategoryForm
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
