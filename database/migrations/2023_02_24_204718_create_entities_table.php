<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('label');
            $table->boolean('built_creation_layout_1')->default(false);
            $table->boolean('built_edition_layout_1')->default(false);
            $table->boolean('built_creation_layout_2')->default(false);
            $table->boolean('built_edition_layout_2')->default(false);
            $table->string('frontend_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entities');
    }
};
