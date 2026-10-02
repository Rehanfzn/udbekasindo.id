<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@udbekasindo.id'],
            [
                'name' => 'Admin UD Bekas Indo',
                'password' => env('APP_ADMIN_PASSWORD', 'password'),
                'is_admin' => true,
            ],
        );
    }
}
