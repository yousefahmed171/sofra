<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('address')->nullable();
			$table->text('notes')->nullable();
			$table->enum('payment_method', array('cash', 'credet'));
			$table->enum('status', array('pending', 'delivered', 'declined', 'accepted', 'rejected', 'receipt_order'))->nullable()->default('pending');
			$table->decimal('price', 8,2)->default('0.0');
			$table->decimal('cost', 8,2)->default('0.0');
			$table->decimal('net', 8,2)->default('0.0');
			$table->decimal('delivery_cost', 8,2)->default('0.0');
			$table->decimal('total_cost', 8,2)->default('0.0');
			$table->decimal('commission', 8,2)->default('0.0');
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::dropIfExists('orders');
	}
}