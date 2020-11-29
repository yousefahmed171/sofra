<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('description');
			$table->decimal('price', 8,2);
			$table->decimal('offer_price', 8,2);
			$table->string('image');
			$table->timestamps();
			$table->integer('restaurant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}