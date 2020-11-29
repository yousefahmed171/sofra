<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactesTable extends Migration {

	public function up()
	{
		Schema::create('contactes', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('massage');
			$table->enum('type', array('complaint', 'suggestion', 'Enquiry'));
		});
	}

	public function down()
	{
		Schema::drop('contactes');
	}
}