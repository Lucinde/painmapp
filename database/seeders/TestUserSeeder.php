<?php

namespace Database\Seeders;

use App\Models\DayLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::all();

        $fysio = null;

        // create fysio
        foreach ($roles as $role) {
            if ($role->name === 'fysio') {
                $email = $role->name . '@example.com';
                $fysio = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => ucfirst($role->name) . ' Test',
                        'password' => Hash::make('password123'),
                        'email_verified_at' => now(),
                    ]
                );
                $fysio->assignRole($role);
                break;
            }
        }

        // create other roles
        foreach ($roles as $role) {
            if ($role->name === 'fysio') {
                continue; // fysio is already there
            }

            $email = $role->name . '@example.com';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => ucfirst($role->name) . ' Test',
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]
            );

            $user->assignRole($role);

            // add relation for client and fysio
            if ($user->hasRole('client') && $fysio) {
                $user->therapist_id = $fysio->id;
                $user->save();

                DayLog::factory()
                    ->forUser($user)
                    ->count(7)
                    ->create();
            }
        }
    }
}
