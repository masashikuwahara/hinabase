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
            'name' => '',
            'email' => '',
            'password' => Hash::make(''), // 初期パスワード
        ]);
    }
}
