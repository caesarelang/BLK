<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::create([
            'name' => 'Alip User',
            'email' => 'alip@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $this->call([
            PelatihanSeeder::class,
            AdminUserSeeder::class,
            PengumumanSeeder::class,
        ]);
    }
}
