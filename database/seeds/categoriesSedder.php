<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categoriesSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'id' => 1,
            'name' => "ارز مندي",
        ]);

        DB::table('categories')->insert([
            'id' => 2,
            'name' => "مياه معدنية",
        ]);

        DB::table('categories')->insert([
            'id' => 3,
            'name' => "مشروبات غازية",
        ]);

        DB::table('categories')->insert([
            'id' => 4,
            'name' => "كنافة",
        ]);
    }
}
