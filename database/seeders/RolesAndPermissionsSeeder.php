<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'view any user',
            'edit any user',
            'create any user',
            'delete any user',
            'view own client',
            'edit own client',
            'create own client',
            'delete own client',
            'view own profile',
            'edit own profile',
            'create own profile',
            'delete own profile'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $therapist = Role::firstOrCreate(['name' => 'therapist']);
        $client = Role::firstOrCreate(['name' => 'client']);

        // Add permissions to role
        $admin->syncPermissions(['view any user', 'create any user', 'edit any user', 'delete any user']);
        $therapist->syncPermissions(['view own client', 'create own client', 'edit own client', 'delete own client']);
        $client->syncPermissions(['view own profile', 'edit own profile']);

    }
}
