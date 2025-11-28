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

        // Add Roles
        $this->call(ShieldSeeder::class);

        // Add Test Users
        // TODO: verwijderen bij livegang
        $this->call(TestUserSeeder::class);
    }
}
