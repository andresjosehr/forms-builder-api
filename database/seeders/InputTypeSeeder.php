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
            ["name" => 'text'],
            ["name" => 'textarea'],
            ["name" => 'number'],
            ["name" => 'date'],
            ["name" => 'select'],
            ["name" => 'checkbox'],
            ["name" => 'radio'],
            ["name" => 'file'],
            ["name" => 'relatedSelect']
        ]);
    }
}
