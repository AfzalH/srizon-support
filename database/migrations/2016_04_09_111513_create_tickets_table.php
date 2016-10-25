<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->index();
            $table->string('secret');
            $table->integer('product_id');
            $table->integer('order_id');
            $table->integer('ticketstatus_id');
            $table->integer('ticketcategory_id');
            $table->integer('user_id');
            $table->text('extra_fields');
            $table->text('email_code');
            $table->tinyInteger('email_verified');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE tickets ADD FULLTEXT search(title)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tickets');
    }
}
