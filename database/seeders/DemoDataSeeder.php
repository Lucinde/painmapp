<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\DayLog;
use App\Models\PainLog;
use App\Models\ActivityLog;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::findByName('super_admin');
        $fysioRole      = Role::findByName('fysio');
        $clientRole     = Role::findByName('client');

        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => config('app.demo.admin_email')],
            [
                'name' => 'Super Admin',
                'password' => Hash::make(config('app.demo.admin_password')), // evt via env
                'email_verified_at' => now(),
            ]
        );

        $superAdmin->assignRole($superAdminRole);

        // Fysios
        $fysios = User::factory()
            ->count(3)
            ->create()
            ->each(fn ($u) => $u->assignRole($fysioRole));

        // Clients + logs
        foreach ($fysios as $fysio) {
            $clients = User::factory()
                ->count(rand(5, 15))
                ->create([
                    'therapist_id' => $fysio->id,
                ])
                ->each(fn ($u) => $u->assignRole($clientRole));

            foreach ($clients as $client) {
                DayLog::factory()
                    ->count(60)
                    ->forUser($client)
                    ->create()
                    ->each(function ($dayLog) {
                        PainLog::factory()
                            ->count(rand(0, 3))
                            ->for($dayLog)
                            ->create();

                        ActivityLog::factory()
                            ->count(rand(0, 2))
                            ->for($dayLog)
                            ->create();
                    });
            }
        }
    }
}
