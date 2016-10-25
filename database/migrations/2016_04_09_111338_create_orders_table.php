<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('p_id')->unsigned();
            $table->string('p_date');
            $table->string('status');
            $table->string('country')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('product_name');
            $table->integer('product_id');;
            $table->string('payment_method');
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
        Schema::drop('orders');
    }
}
