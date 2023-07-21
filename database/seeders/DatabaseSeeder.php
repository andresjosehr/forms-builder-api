<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);

        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('fields')->truncate();
        DB::table('entities')->truncate();
        DB::table('sql_properties')->truncate();
        DB::table('relationship_properties')->truncate();
        DB::table('validations')->truncate();
        DB::table('relationships')->truncate();
        DB::table('validations')->truncate();
        DB::table('steps')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call(InputTypeSeeder::class);
        $this->call(RelationTypeSeeder::class);
        $this->call(SqlPropertyTypeSeeder::class);
        $this->call(ValidationsSeeder::class);
    }
}
