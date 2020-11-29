<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('password');
			$table->string('phone');
			$table->string('whatsapp')->nullable();
			$table->string('image');
			$table->enum('status', array('open', 'closed'));
			$table->integer('minimum_order');
			$table->decimal('delivery_cost', 8,2);
			$table->boolean('activated')->default(1);
			$table->string('pin_code', 6)->nullable();
			$table->string('api_token', 60)->unique()->nullable();
			$table->integer('region_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::dropIfExists('restaurants');
	}
}