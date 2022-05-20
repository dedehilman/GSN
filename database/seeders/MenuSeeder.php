<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Storage;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get("seeder/menu.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            $data = new Menu();
            $data->code = $obj->code;
            $data->title = $obj->title;
            $data->class = $obj->class;
            $data->nav_header = $obj->nav_header;
            $data->link = $obj->link;
            $data->sequence = $obj->sequence;
            $data->display = $obj->display;
            $data->parent_id = $obj->parent_id;
            $data->save();       
        }
    }
}
