<?php

use Illuminate\Database\Seeder;

class ProductTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productTypes = [
            ['name' => 'Car'],
            ['name' => 'Motorcycle'],
            ['name' => 'Property'],
            ['name' => 'Electronic & Gadgets'],
            ['name' => 'Hobbies and sports']
        ];

        foreach($productTypes as $productType) {
            \App\Entities\ProductType::create($productType);
        }
    }
}
