<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->tinyInteger('status');
            $table->uuid('customer_id')->references('id')->on('customers')->nullable(true);
            $table->string('customer_last_name');
            $table->string('customer_first_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->double('amount',8,2);
            $table->string('payment_method');
            $table->text('payment_info');
            $table->string('message');
            $table->string('security');
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
        Schema::dropIfExists('transactions');
    }
}
