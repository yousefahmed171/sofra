<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->text('address')->nullable();
			$table->string('pin_code', 6)->nullable();
			$table->string('api_token', 60)->nullable();
			$table->integer('region_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}