<?php

namespace App\Console\Commands;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    protected $signature = 'create-admin';

    protected $description = 'Create admin account';

    protected $aliases = [
        'make:admin',
    ];

    public function handle(): int
    {
        $email = $this->ask('Email администратора', 'admin@example.com');
        $password = $this->secret('Пароль администратора') ?? 'admin';
        $name = $this->ask('ФИО администратора', 'Admin');
        $phone = $this->ask('Телефон администратора', '+79124567890');

        $user = User::create([
            'email' => $email,
            'password' => $password,
            'name' => $name,
            'phone' => $phone,
            'role' => UserRoleEnum::ADMIN,
        ]);

        $this->info("Аккаунт {$user->email} создан!");

        return self::SUCCESS;
    }
}
