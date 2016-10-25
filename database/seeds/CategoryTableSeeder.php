<?php

use App\Productcategory;
use App\Ticketcategory;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    /**
     *
     */
    public function run()
    {
//        $faker = Faker\Factory::create();

        $prod_category_array = collect([
            'Wordpress Plugin',
            'Wordpress Theme',
            'Joomla Extension',
            'Joomla Template',
            'Laravel Application',
            'PHP Application',
            'HTML/CSS/JS'
        ]);

        $ticket_category_array = collect([
            'Installation',
            'Download',
            'Update',
            'Layout',
            'Performance',
            'No Output',
            'Error Message'
        ]);

        while ($item = $prod_category_array->pop()) {
            $cat = new Productcategory();
            $cat->name = $item;
            $cat->icon = 'fa fa-exclamation-circle';
            $cat->description = '';
            $cat->save();
        }

        while ($item = $ticket_category_array->pop()) {
            $cat = new Ticketcategory();
            $cat->name = $item;
            $cat->save();
        }
    }
}
