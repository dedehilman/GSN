<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Storage;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get("seeder/permission.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            $data = new Permission();
            $data->name = $obj->name;
            $data->save();       
        }
    }
}
