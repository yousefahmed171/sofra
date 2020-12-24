<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration {

	public function up()
	{
		Schema::create('payments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->decimal('amount', 8,2);
			$table->date('date');
			$table->text('note');
			$table->integer('restaurant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::dropIfExists('payments');
	}
}