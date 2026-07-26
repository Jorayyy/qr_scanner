<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🔑 1. AUTOMATIC DEDICATED ADMINISTRATOR ACCOUNT
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@evsu.edu.ph'],
            [
                'name' => 'Master Administrator',
                'password' => bcrypt('admin1234'),
                'role' => 'admin'
            ]
        );

        // 🛡️ 2. AUTOMATIC DEDICATED CAMPUS GUARD ACCOUNT
        \App\Models\User::updateOrCreate(
            ['email' => 'guard@evsu.edu.ph'],
            [
                'name' => 'Campus Guard Personnel',
                'password' => bcrypt('guard1234'),
                'role' => 'guard'
            ]
        );

        // Keep any other seeders you have below this line...
    }
}
