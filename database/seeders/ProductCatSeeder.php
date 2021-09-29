<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('products')->insert([
            'product_title' => 'soup',
            'product_desc' => 'Soup is good'
        ]);
    }
}
