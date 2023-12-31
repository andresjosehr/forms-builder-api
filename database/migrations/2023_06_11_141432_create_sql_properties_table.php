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
        Schema::create('sql_properties', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sql_property_type_id');
            $table->foreign('sql_property_type_id')->references('id')->on('sql_property_types');

            $table->unsignedBigInteger('related_entity_id')->nullable();
            $table->foreign('related_entity_id')->references('id')->on('entities');

            $table->unsignedBigInteger('field_id');
            $table->foreign('field_id')->references('id')->on('fields');

            $table->integer('length')->nullable();
            $table->boolean('nullable');
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
        Schema::dropIfExists('sql_properties');
    }
};
