<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('description');
			$table->decimal('price', 8,2);
			$table->string('image');
			$table->dateTime('start_date');
			$table->dateTime('end_date');
			$table->integer('restaurant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::dropIfExists('offers');
	}
}