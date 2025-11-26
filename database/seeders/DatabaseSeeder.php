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
        // User::factory(10)->create();

        $user = User::firstOrCreate(
            ['email' => 'test@example.com'], // unieke zoekcriteria
            [
                'name' => 'Test User',
                'password' => bcrypt('password123'), // vergeet wachtwoord niet
            ]
        );

        // Add Roles
        $this->call(ShieldSeeder::class);
    }
}
