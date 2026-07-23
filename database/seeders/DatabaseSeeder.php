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
    // Automatically creates your superadmin account on every fresh migration loop!
    \App\Models\User::updateOrCreate(
        ['email' => 'superadmin@gmail.com'],
        [
            'name' => 'Master Administrator',
            'password' => bcrypt('superadmin1234'),
            'role' => 'admin'
        ]
    );

    // Keep any other seeders you have below this line...
}

}
