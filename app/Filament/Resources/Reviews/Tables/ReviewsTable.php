<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Enums\ReviewStatusEnum;
use App\Models\Review;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable(['name', 'email'])
                    ->sortable()
                    ->description(fn (Review $record): string => $record->user->email)
                    ->toggleable(),

                TextColumn::make('product.name')
                    ->label('Товар')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Review $record): string => $record->product->status->getLabel())
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Статус')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('rating')
                    ->label('Рейтинг')
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
                SelectFilter::make('status')
                    ->label('Статус')
                    ->native(false)
                    ->options(ReviewStatusEnum::class),

                SelectFilter::make('user_id')
                    ->label('Пользователь')
                    ->relationship('user', 'name')
                    ->searchable(['name', 'email'])
                    ->native(false)
                    ->preload(),

                SelectFilter::make('product_id')
                    ->label('Товар')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->native(false)
                    ->preload(),
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
