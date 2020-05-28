<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flowers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('catalog_id')->references('id')->on('catalogs')->onDelete('cascade');
            $table->string('name');
            $table->string('color')->nullable(true);
            $table->double('price', 8,2)->nullable(true);
            $table->integer('discount')->nullable(true);
            $table->string('avatar')->nullable(true);
            $table->text('images')->nullable(true);
            $table->integer('view')->nullable(true);
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
        Schema::dropIfExists('flowers');
    }
}
