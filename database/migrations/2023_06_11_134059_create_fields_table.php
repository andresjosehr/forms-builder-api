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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('label');
            $table->boolean('built_creation')->default(false);
            $table->boolean('built_edition')->default(false);

            $table->unsignedBigInteger('field_type_id');
            $table->foreign('field_type_id')->references('id')->on('field_types');

            $table->unsignedBigInteger('input_type_id');
            $table->foreign('input_type_id')->references('id')->on('input_types');

            $table->boolean('searchable');

            $table->unsignedBigInteger('entity_id');
            $table->foreign('entity_id')->references('id')->on('entities');

            $table->boolean('visible');
            $table->boolean('editable');





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
        Schema::dropIfExists('fields');
    }
};
