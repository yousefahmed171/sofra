<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([

            categoriesSedder::class,
            citiesSedder::class,
            regionsSedder::class,
            PermissionsSeeder::class,
            RolesSeeder::class
            // permissionsSedder::class,
            // rolesSedder::class,

         ]);
    }
}
