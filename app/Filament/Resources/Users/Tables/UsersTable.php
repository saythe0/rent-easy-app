<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\UserRoleEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('name')
                    ->label('ФИО')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('email')
                    ->label('Почта')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('role')
                    ->label('Роль')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->deferFilters(false)
            ->filters([
                SelectFilter::make('role')
                    ->label('Роль')
                    ->options(UserRoleEnum::class)
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
