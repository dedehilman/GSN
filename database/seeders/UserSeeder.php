<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all()->pluck('id');
        $data = new User();
        $data->name = 'Administrator';
        $data->username = 'administrator';
        $data->email = 'administrator@gmail.com';
        $data->password = Hash::make('administrator');
        $data->save();
        $data->syncRoles($roles);
    }
}
