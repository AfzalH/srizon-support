<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_array = collect([
            'Srizon Lorem',
            'Srizon Tag',
            'Srizon Image Slider',
            'Srizon Flickr Gallery',
            'Srizon Facebook Video Gallery',
            'Srizon Responsive Youtube Album',
            'Srizon Facebook Album',
            'JFBAlbum',
            'JUserTube',
            'Other/General',
        ]);

        $product_paypro_array = collect([
            '',
            'Srizon Tag',
            'Srizon Image Slider',
            'Srizon Flickr Gallery',
            'Srizon Facebook Video Gallery',
            'SrizonYoutubeAlbumPro',
            'Srizon Facebook Album Pro',
            'JFBAlbum',
            'JUserTube',
            '',
        ]);
        while ($prod_name = $product_array->pop()) {
            $product = new Product();
            $product->name = $prod_name;
            $product->paypro_name = $product_paypro_array->pop();
            $product->save();
        }
    }
}
