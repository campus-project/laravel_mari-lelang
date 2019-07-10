<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBidsTable.
 */
class CreateBidsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bids', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('auction_product_id');
            $table->foreign('auction_product_id')->references('id')->on('auction_products')->onUpdate('cascade');
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
		Schema::drop('bids');
	}
}
