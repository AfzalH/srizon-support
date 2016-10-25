<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketpostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticketposts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->integer('ticket_id');
            $table->string('secrecy');
            $table->integer('user_id');
            $table->string('status');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE ticketposts ADD FULLTEXT search(body)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ticketposts');
    }
}
