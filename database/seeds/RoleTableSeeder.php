<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles_array = collect([
            ['Customer', 'customer'],
            ['Support', 'support']
        ]);
        while ($role_element = $roles_array->pop()) {
            $role = new Role();
            $role->name = $role_element[0];
            $role->alias = $role_element[1];
            $role->save();
        }

        $permission = new Permission();
        $permission->name = 'Support';
        $permission->alias = 'support';
        $permission->save();
        $permission->roles()->attach(Role::whereAlias('support')->first()->id);
    }
}
