<?php

use App\Productcategory;
use App\Ticketcategory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOthersCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Productcategory::destroy(1);
        $cat = new Productcategory();
        $cat->id = 1;
        $cat->name = 'Others';
        $cat->icon = 'fa fa-exclamation-circle';
        $cat->description = 'Default category for any product';
        $cat->save();

        Ticketcategory::destroy(1);
        $a = new Ticketcategory();
        $a->id = 1;
        $a->name = 'Something else';
        $a->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Productcategory::destroy(1);
        Ticketcategory::destroy(1);
    }
}
