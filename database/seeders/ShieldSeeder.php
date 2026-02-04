<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        // Cache van Spatie permissies resetten
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Rollen met bijbehorende permissies
        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["ViewAny:Role","View:Role","Create:Role","Update:Role","Delete:Role","Restore:Role","ForceDelete:Role","ForceDeleteAny:Role","RestoreAny:Role","Replicate:Role","Reorder:Role","ViewAny:User","View:User","Create:User","Update:User","Delete:User","Restore:User","ForceDelete:User","ForceDeleteAny:User","RestoreAny:User","Replicate:User","Reorder:User","ViewAny:DayLog","View:DayLog","Create:DayLog","Update:DayLog","ForceDeleteAny:DayLog","ForceDelete:DayLog","Delete:DayLog","Restore:DayLog","RestoreAny:DayLog","Replicate:DayLog","Reorder:DayLog","ViewOwn:DayLog","ViewClient:DayLog","ViewClient:User","View:ActiveClients","View:PainActivityStats","View:PainActivityChart"]},{"name":"fysio","guard_name":"web","permissions":["View:Role","View:User","Create:User","Update:User","Delete:User","View:DayLog","Create:DayLog","Update:DayLog","ViewOwn:DayLog","ViewClient:DayLog","ViewClient:User","View:ActiveClients"]},{"name":"client","guard_name":"web","permissions":["View:User","Update:User","View:DayLog","Create:DayLog","Update:DayLog","ForceDelete:DayLog","Delete:DayLog","Restore:DayLog","Replicate:DayLog","Reorder:DayLog","ViewOwn:DayLog","View:PainActivityStats","View:PainActivityChart"]}]';

        // Directe permissies
        $directPermissions = '{"36":{"name":"ViewAssigned:User","guard_name":"web"},"37":{"name":"ViewOwn:User","guard_name":"web"}}';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    /**
     * Rollen en hun permissies aanmaken/syncen.
     *
     * @param string $rolesWithPermissions JSON string van rollen + permissies
     */
    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        $rolePlusPermissions = json_decode($rolesWithPermissions, true);

        if (!empty($rolePlusPermissions)) {
            /** @var class-string<Role> $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var class-string<Permission> $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $roleData) {
                $role = $roleModel::firstOrCreate([
                    'name' => $roleData['name'],
                    'guard_name' => $roleData['guard_name'],
                ]);

                if (!empty($roleData['permissions'])) {
                    $permissionModels = collect($roleData['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $roleData['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    /**
     * Directe permissies aanmaken.
     *
     * @param string $directPermissions JSON string van directe permissies
     */
    public static function makeDirectPermissions(string $directPermissions): void
    {
        $permissions = json_decode($directPermissions, true);

        if (!empty($permissions)) {
            /** @var class-string<Permission> $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission['name'])->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
