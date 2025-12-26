<?php

namespace App\Filament\Resources\Reviews\Schemas;

use App\Enums\ReviewStatusEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\TextSize;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Пользователь')
                    ->relationship('user', 'name')
                    ->native(false)
                    ->searchable(['name', 'email'])
                    ->required()
                    ->preload(),

                Select::make('product_id')
                    ->label('Товар')
                    ->relationship('product', 'name')
                    ->native(false)
                    ->searchable()
                    ->required()
                    ->preload(),

                Select::make('status')
                    ->options(ReviewStatusEnum::class)
                    ->label('Статус')
                    ->native(false)
                    ->required(),

                Select::make('rating')
                    ->label('Рейтинг (звезды)')
                    ->options([
                        5 => '⭐⭐⭐⭐⭐',
                        4 => '⭐⭐⭐⭐',
                        3 => '⭐⭐⭐',
                        2 => '⭐⭐',
                        1 => '⭐',
                    ])
                    ->required()
                    ->native(false)
                    ->default(5),

                Textarea::make('comment')
                    ->label('Комментарий пользователя')
                    ->required()
                    ->autosize()
                    ->columnSpanFull(),
            ]);
    }
}
