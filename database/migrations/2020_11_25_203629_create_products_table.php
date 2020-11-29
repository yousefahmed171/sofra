<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
			$table->integer('restaurant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::dropIfExists('products');
	}
}