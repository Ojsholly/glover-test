<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = ['request update', 'approve update', 'decline update'];

        foreach($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'user']);

        $admin = Role::create(['name' => 'admin']);

        $admin->syncPermissions($permissions);
    }
}
