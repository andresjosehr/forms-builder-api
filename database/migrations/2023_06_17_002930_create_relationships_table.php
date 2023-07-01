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
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('entity_id');
            $table->foreign('entity_id')->references('id')->on('entities');

            $table->unsignedBigInteger('relation_type_id');
            $table->foreign('relation_type_id')->references('id')->on('relation_types');

            $table->unsignedBigInteger('related_entity_id');
            $table->foreign('related_entity_id')->references('id')->on('entities');

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
        Schema::dropIfExists('relationships');
    }
};
