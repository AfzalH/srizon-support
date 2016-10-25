<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketTicketcategoryPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_ticketcategory', function (Blueprint $table) {
            $table->integer('ticketcategory_id')->unsigned()->index();
            $table->foreign('ticketcategory_id')->references('id')->on('ticketcategories')->onDelete('cascade');
            $table->integer('ticket_id')->unsigned()->index();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->primary(['ticketcategory_id', 'ticket_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ticket_ticketcategory');
    }
}
