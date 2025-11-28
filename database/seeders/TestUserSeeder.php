<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::all();

        foreach ($roles as $role) {
            $email = $role->name . '@example.com';

            if (!User::where('email', $email)->exists()) {
                $user = User::create([
                    'name'     => ucfirst($role->name) . ' Test',
                    'email'    => $email,
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]);

                $user->assignRole($role);
            }
        }
    }
}
