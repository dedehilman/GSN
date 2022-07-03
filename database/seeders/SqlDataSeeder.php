<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Storage;
use Illuminate\Support\Facades\DB;

class SqlDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Storage::exists("seeder/data.sql")) {
            $sql = Storage::get("seeder/data.sql");
            DB::unprepared($sql);    
        }
    }
}
