<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class App extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the table
        DB::table('apps')->truncate();

        // Faker
        $faker = \Faker\Factory::create();

        // Create 100 houses
        for ($i = 0; $i < 100; $i++) {
            DB::table('apps')->insert([

                'name' => $faker->text(),
				

                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
