<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class regionsSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('regions')->insert([
            'id' => 1,
            'name' => " حي العليا",
            'city_id' => '1'
        ]);

        DB::table('regions')->insert([
            'id' => 2,
            'name' => " حي الملك عبد العزيز",
            'city_id' => '1'
        ]);

        DB::table('regions')->insert([
            'id' => 3,
            'name' => " حي الملك عبد الله الجنوبي",
            'city_id' => '1'
        ]);

        DB::table('regions')->insert([
            'id' => 4,
            'name' => " حي  الملك عبد الله الشمالي",
            'city_id' => '1'
        ]);

        DB::table('regions')->insert([
            'id' => 5,
            'name' => " حي الواحة",
            'city_id' => '1'
        ]);

        DB::table('regions')->insert([
            'id' => 6,
            'name' => " حي صلاح الدين",
            'city_id' => '1'
        ]);

        DB::table('regions')->insert([
            'id' => 7,
            'name' => " حي الورود",
            'city_id' => '1'
        ]);

        DB::table('regions')->insert([
            'id' => 8,
            'name' => " حي المرسلات ",
            'city_id' => '1'
        ]);

        DB::table('regions')->insert([
            'id' => 9,
            'name' => " حي النزهة ",
            'city_id' => '1'
        ]);

        DB::table('regions')->insert([
            'id' => 10,
            'name' => " حي المغرزات ",
            'city_id' => '1'
        ]);

        DB::table('regions')->insert([
            'id' => 11,
            'name' => " حي الازدهار ",
            'city_id' => '1'
        ]);

        DB::table('regions')->insert([
            'id' => 12,
            'name' => " حي التعاون ",
            'city_id' => '1'
        ]);

        DB::table('regions')->insert([
            'id' => 13,
            'name' => " حي المصيف ",
            'city_id' => '1'
        ]);
    }
}
