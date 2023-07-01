<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValidationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // truncate table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('validations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('validations')->insert([
            [
                'name' => 'required',
                "label" => "Requerido",
                "extra_info" => false,
                "front_validation" => "Validators.required",
                "back_validation" => "required",
            ],
            [
                'name' => 'email',
                "label" => "Tipo email",
                "extra_info" => false,
                "front_validation" => "Validators.email",
                "back_validation" => "email",
            ],
            [
                'name' => 'max',
                "label" => "Máximo",
                "extra_info" => true,
                "front_validation" => "Validators.max",
                "back_validation" => "max",
            ],
            [
                'name' => 'min',
                "label" => "Mínimo",
                "extra_info" => true,
                "front_validation" => "Validators.min",
                "back_validation" => "min",
            ],
            [
                'name' => 'maxLength',
                "label" => "Longitud máxima",
                "extra_info" => true,
                "front_validation" => "Validators.maxLength",
                "back_validation" => "max_digits"
            ],
            [
                'name' => 'minLength',
                "label" => "Longitud mínima",
                "extra_info" => true,
                "front_validation" => "Validators.minLength",
                "back_validation" => "min_digits",
            ],
            [
                'name' => 'unique',
                "label" => "Único",
                "extra_info" => false,
                "front_validation" => "",
                "back_validation" => "unique",
            ],
            [
                'name' => 'regex',
                "label" => "Expresion regular",
                "extra_info" => true,
                "front_validation" => "Validators.pattern",
                "back_validation" => "regex",
            ],
        ]);
    }
}
