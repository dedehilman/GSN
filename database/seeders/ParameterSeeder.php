<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameter;
use Storage;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get("seeder/parameter.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            $data = new Parameter();
            $data->key = $obj->key;
            $data->value = $obj->value;
            $data->save();       
        }
    }
}
