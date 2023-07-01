<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SqlPropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sql_property_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('sql_property_types')->insert([
            ["name" => 'string'],
            ["name" => 'integer'],
            ["name" => 'relatedEntity']
        ]);
    }
}
