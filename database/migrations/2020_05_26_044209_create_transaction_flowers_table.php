<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionFlowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_flower', function (Blueprint $table) {
            $table->id();
            $table->uuid('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->uuid('flower_id')->references('id')->on('flowers')->onDelete('cascade');
            $table->integer('qty');
            $table->double('amount',8,2);
            $table->text('data')->nullable(true);
            $table->tinyInteger('status');
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
        Schema::dropIfExists('transaction_flower');
    }
}
