<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InputTypeSeeder extends Seeder
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
        DB::table('input_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('input_types')->insert([
            ["name" => 'text', 'sql_type' => 'string'],
            ["name" => 'textarea', 'sql_type' =>'longText' ],
            ["name" => 'number', 'sql_type' => 'integer'],
            ["name" => 'date', 'sql_type' => 'date'],
            ["name" => 'select', 'sql_type' =>'string'],
            ["name" => 'checkbox', 'sql_type' => 'boolean'],
            ["name" => 'radio', 'sql_type' => 'string'],
            ["name" => 'file', 'sql_type' => 'jsonb'],
            // ["name" => 'relatedSelect']
        ]);
    }
}
