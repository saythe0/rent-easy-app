<?php

namespace App\Filament\Resources\Applications\Schemas;

use App\Enums\ApplicationStatusEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Пользователь')
                    ->relationship('user', 'name')
                    ->searchable(['name', 'email'])
                    ->native(false)
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
                    ->options(ApplicationStatusEnum::class)
                    ->label('Статус заявки')
                    ->native(false)
                    ->required(),

                TextInput::make('amount')
                    ->label('Сумма')
                    ->required()
                    ->numeric()
                    ->inputMode('decimal')
                    ->prefix('₽'),

                Toggle::make('is_paid')
                    ->label('Оплачено')
                    ->required()
                    ->inline(false)
                    ->default(false),

                Textarea::make('comment')
                    ->label('Комментарий пользователя')
                    ->autosize(),

                DatePicker::make('rental_start_date')
                    ->label('Дата начала аренды')
                    ->required(),

                DatePicker::make('rental_end_date')
                    ->label('Дата окончания аренды')
                    ->required()
                    ->rule('after_or_equal:rental_start_date'),

                Textarea::make('manager_note')
                    ->label('Заметки менеджера (видны только в админ панели)')
                    ->autosize(),
            ]);
    }
}
