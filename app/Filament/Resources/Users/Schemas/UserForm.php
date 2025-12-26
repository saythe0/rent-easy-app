<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRoleEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Фамилия Имя Отчество')
                    ->maxLength(255)
                    ->required(),

                TextInput::make('email')
                    ->label('Почта')
                    ->email()
                    ->maxLength(255)
                    ->required(),

                Select::make('role')
                    ->label('Роль')
                    ->options(UserRoleEnum::class)
                    ->required()
                    ->native(false),

                TextInput::make('password')
                    ->label('Пароль')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->maxLength(255)
                    ->autocomplete('new-password')
                    ->afterStateHydrated(fn ($state, callable $set) => $set('password', null))
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->helperText(fn (string $operation): ?string => $operation === 'edit'
                        ? 'Оставьте пустым, если не хотите менять пароль'
                        : null
                    ),

                TextInput::make('phone')
                    ->label('Телефон')
                    ->mask('+79999999999')
                    ->tel()
                    ->required(),
            ]);
    }
}
