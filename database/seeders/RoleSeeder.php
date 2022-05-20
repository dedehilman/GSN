<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Menu;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    private $roles = [
        "administrator",
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all()->pluck('id');
        $menus = Menu::all()->pluck('id');
        foreach ($this->roles as $role) {
            $data = new Role();
            $data->name = $role;
            $data->save();
            $data->syncPermissions($permissions);
            $data->syncMenus($menus);
        }
    }
}
