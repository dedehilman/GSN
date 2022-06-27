<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppearanceSetting;

class AppearanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new AppearanceSetting();
        $data->sidebar_theme = 'light';
        $data->type = 'global';
        $data->save();
    }
}
