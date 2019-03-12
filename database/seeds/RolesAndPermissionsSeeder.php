<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        Permission::create(['name' => 'create task for own']);
        Permission::create(['name' => 'todo']);
        Permission::create(['name' => 'done']);
        Permission::create(['name' => 'verified']);


        Permission::create(['name' => 'create task for all']);
        Permission::create(['name' => 'get all tasks']);
        Permission::create(['name' => 'edit task for all']);
        Permission::create(['name' => 'show all task']);


        // create roles and assign created permissions

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());


        $role = Role::create(['name' => 'developer']);
        $role->givePermissionTo(['create task for own', 'todo task', 'done task']);
    }
}
