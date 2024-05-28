<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $role = Role::create(['name' => 'admin']);
        $admin[0] = Permission::create(['name' => 'create_user']);
        $admin[1] = Permission::create(['name' => 'update_user']);
        $admin[2] = Permission::create(['name' => 'delete_user']);
        $admin[3] = Permission::create(['name' => 'cat_users']);
        $role->syncPermissions($admin);
        $role = Role::create(['name' => 'user']);
        $user[0] = $admin[3];
        $role->syncPermissions($user);
    }
}
