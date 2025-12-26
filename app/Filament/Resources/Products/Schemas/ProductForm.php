<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Enums\ProductConditionEnum;
use App\Enums\ProductStatusEnum;
use App\Filament\Resources\ProductCategories\Schemas\ProductCategoryForm;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\TextSize;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('slug')
                    ->label('ЧПУ')
                    ->helperText('генерируется всегда автоматически используя краткий заголовок')
                    ->copyable()
                    ->fontFamily(FontFamily::Mono)
                    ->size(TextSize::Medium)
                    ->columnSpanFull()
                    ->hiddenOn('create'),

                Select::make('product_category_id')
                    ->label('Категория')
                    ->relationship('category', 'name')
                    ->native(false)
                    ->searchable()
                    ->createOptionForm(ProductCategoryForm::getComponents())
                    ->createOptionModalHeading('Добавить новую категорию')
                    ->required()
                    ->preload(),

                Select::make('condition')
                    ->options(ProductConditionEnum::class)
                    ->label('Статус товара')
                    ->native(false)
                    ->required(),

                Select::make('status')
                    ->options(ProductStatusEnum::class)
                    ->label('Состояние товара')
                    ->native(false)
                    ->required(),

                TextInput::make('price')
                    ->label('Стоимость за 1 день')
                    ->required()
                    ->numeric()
                    ->inputMode('decimal')
                    ->prefix('₽'),

                Toggle::make('is_active')
                    ->label('Активно')
                    ->required()
                    ->inline(false)
                    ->default(true),

                TextInput::make('name')
                    ->label('Название товара')
                    ->maxLength(255)
                    ->required(),

                Textarea::make('description')
                    ->label('Описание товара')
                    ->autosize(),

                TextInput::make('brand')
                    ->label('Бренд товара')
                    ->maxLength(255)
                    ->required(),

                TextInput::make('model')
                    ->label('Модель товара')
                    ->maxLength(255)
                    ->required(),
            ]);
    }
}
