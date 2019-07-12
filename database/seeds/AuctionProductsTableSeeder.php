<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AuctionProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $auctionProducts = [
            [
                'name' => 'Honda Jazz S MT 2014 LOW KM Kondisi Sangat Istimewa',
                'offer' => 1000000,
                'description' => '<p><br></p>',
                'product_type_id' => 1,
                'city_id' => 159
            ]
        ];

        $auctionProductPhotos = [
            [
                'name' => 'e0172e33002e0cffd40288dce00bfdc6.jpg',
                'photo_url' => 'images/products/e0172e33002e0cffd40288dce00bfdc6.jpg',
                'type' => 'image/jpg',
            ],
            [
                'name' => 'c3210ae24d7ad97cf2cc4a4536c27a2e.jpg',
                'photo_url' => 'images/products/c3210ae24d7ad97cf2cc4a4536c27a2e.jpg',
                'type' => 'image/jpg',
            ]
        ];

        //1 Day
        for($i=0;$i<12;$i++) {
            foreach($auctionProducts as $auctionProduct) {
                $auctionProduct['created_by'] = 1;
                $auctionProduct['updated_by'] = 1;
                $auctionProduct['city_id'] += $i;
                $auctionProduct['start_date'] = now();
                $auctionProduct['end_date'] = Carbon::now()->addDay();

                $product = \App\Entities\AuctionProduct::create($auctionProduct);

                foreach($auctionProductPhotos as $auctionProductPhoto) {
                    $auctionProductPhoto['auction_product_id'] = $product->id;
                    \App\Entities\AuctionProductPhoto::create($auctionProductPhoto);
                }
            }
        }

        //Limited 30 Minutes
        for($i=0;$i<12;$i++) {
            foreach($auctionProducts as $auctionProduct) {
                $auctionProduct['created_by'] = 1;
                $auctionProduct['updated_by'] = 1;
                $auctionProduct['city_id'] += $i;
                $auctionProduct['start_date'] = now();
                $auctionProduct['end_date'] = Carbon::now()->addMinutes(30);

                $product = \App\Entities\AuctionProduct::create($auctionProduct);

                foreach($auctionProductPhotos as $auctionProductPhoto) {
                    $auctionProductPhoto['auction_product_id'] = $product->id;
                    \App\Entities\AuctionProductPhoto::create($auctionProductPhoto);
                }
            }
        }
    }
}
