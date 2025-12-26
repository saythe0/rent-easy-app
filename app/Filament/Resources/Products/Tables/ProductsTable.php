<?php

namespace App\Filament\Resources\Products\Tables;

use App\Enums\ProductConditionEnum;
use App\Enums\ProductStatusEnum;
use App\Models\Application;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label('Категория')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('slug')
                    ->label('Статус')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('name')
                    ->label('Статус')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Статус')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('condition')
                    ->label('Состояние')
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('Активно')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->deferFilters(false)
            ->filters([
                SelectFilter::make('product_category_id')
                    ->label('Категория')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->native(false)
                    ->preload(),

                SelectFilter::make('status')
                    ->label('Статус')
                    ->native(false)
                    ->options(ProductStatusEnum::class),

                SelectFilter::make('condition')
                    ->label('Состояние')
                    ->native(false)
                    ->options(ProductConditionEnum::class),

                TernaryFilter::make('is_active')
                    ->label('Активно')
                    ->placeholder('Все')
                    ->trueLabel('Да')
                    ->falseLabel('Нет')
                    ->native(false),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
