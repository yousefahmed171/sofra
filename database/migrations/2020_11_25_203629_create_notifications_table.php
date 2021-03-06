<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title');
			$table->string('content');
			$table->integer('order_id')->unsigned();
			$table->boolean('is_ready')->default(0);
			$table->integer('notificationable_id');
			$table->string('notificationable_type');
		});
	}

	public function down()
	{
		Schema::dropIfExists('notifications');
	}
}