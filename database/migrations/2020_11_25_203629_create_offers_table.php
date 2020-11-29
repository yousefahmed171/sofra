<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
			$table->date('start_date');
			$table->date('end_date');
			$table->integer('restaurant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}