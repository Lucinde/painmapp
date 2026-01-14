<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\DayLog;
use App\Models\PainLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::all();

        // create fysiotherapists
        $fysioRole = $roles->firstWhere('name', 'fysio');

        $fysios = collect();

        for ($i = 1; $i <= 2; $i++) {
            $fysio = User::firstOrCreate(
                ['email' => "fysio{$i}@example.com"],
                [
                    'name' => "Fysio {$i}",
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]
            );

            $fysio->assignRole($fysioRole);
            $fysios->push($fysio);
        }

        // create other roles
        foreach ($roles as $role) {
            if ($role->name === 'fysio') {
                continue;
            }

            $user = User::firstOrCreate(
                ['email' => $role->name . '@example.com'],
                [
                    'name' => ucfirst($role->name) . ' Test',
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]
            );

            $user->assignRole($role);
        }

        // create clients with daylogs and add them to different fysios
        $clientRole = $roles->firstWhere('name', 'client');

        foreach ($fysios as $fysio) {
            // elke fysio krijgt 2–4 clients
            $clientCount = rand(2, 4);

            for ($i = 1; $i <= $clientCount; $i++) {
                $client = User::create([
                    'name' => "Client {$fysio->id}-{$i}",
                    'email' => "client_{$fysio->id}_{$i}@example.com",
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                    'therapist_id' => $fysio->id,
                ]);

                $client->assignRole($clientRole);

                // create daylogs for clients
                $dayLogs = collect();

                for ($daysAgo = 0; $daysAgo < 30; $daysAgo++) {
                    $date = now()->subDays($daysAgo)->startOfDay();

                    $dayLog = DayLog::factory()
                        ->forUser($client)
                        ->create([
                            'date' => $date,
                        ]);

                    // voeg random painlogs en activitylogs toe
                    if (rand(1, 100) <= 70) {
                        PainLog::factory()
                            ->for($dayLog)
                            ->count(rand(1, 4))
                            ->create();
                    }

                    if (rand(1, 100) <= 80) {
                        ActivityLog::factory()
                            ->for($dayLog)
                            ->count(rand(1, 3))
                            ->create();
                    }

                    $dayLogs->push($dayLog);
                }

            }
        }
    }
}
