<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'るんちゃん',
            'email' => 'example@email.com',
            'password' => Hash::make('qwerty7'), // 初期パスワード
        ]);
    }
}
