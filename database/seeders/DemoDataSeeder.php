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
                'password' => Hash::make(config('app.demo.admin_password')),
                'email_verified_at' => now(),
            ]
        );

        $superAdmin->assignRole($superAdminRole);

        // Fysios
        $fysios = User::factory()
            ->count(3)
            ->create()
            ->each(function ($u, $index) use ($fysioRole) {
                $u->assignRole($fysioRole);
                $u->password = Hash::make(config('app.demo.fysio_password'));
                $u->save();
            });

        // Clients + logs
        foreach ($fysios as $fysio) {
            $clients = User::factory()
                ->count(rand(5, 15))
                ->create([
                    'therapist_id' => $fysio->id,
                ])
                ->each(function ($u, $index) use ($clientRole) {
                    $u->assignRole($clientRole);
                    $u->password = Hash::make(config('app.demo.client_password'));
                    $u->save();
                });

            foreach ($clients as $client) {
                $dates = collect(range(0, 59))
                    ->filter(fn () => rand(0, 100) > 20)
                    ->map(fn ($daysAgo) => now()->subDays($daysAgo)->toDateString());

                foreach ($dates as $date) {
                    $dayLog = DayLog::factory()
                        ->forUser($client)
                        ->create([
                            'date' => $date,
                        ]);

                    PainLog::factory()
                        ->count(rand(0, 3))
                        ->for($dayLog)
                        ->create();

                    ActivityLog::factory()
                        ->count(rand(0, 2))
                        ->for($dayLog)
                        ->create();
                }
            }
        }
    }
}
