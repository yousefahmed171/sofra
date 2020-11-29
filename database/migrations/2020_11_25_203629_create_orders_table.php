<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('address')->nullable();
			$table->text('notes')->nullable();
			$table->enum('payment_method', array('cash', 'credet'));
			$table->enum('status', array('pending', 'accepted', 'rejected', 'delivered', 'declined'))->nullable();
			$table->decimal('price', 8,2);
			$table->decimal('delivery_cost', 8,2);
			$table->decimal('total_cost', 8,2);
			$table->decimal('commission', 8,2);
			$table->integer('user_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}