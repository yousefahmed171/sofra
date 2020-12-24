<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('about');
			$table->string('phone');
			$table->string('facebook_link')->nullable();
			$table->string('instagram_link')->nullable();
			$table->string('twitter_link')->nullable();
			$table->string('youtube_link')->nullable();
			$table->string('whatsapp_link')->nullable();
			$table->string('android_link')->nullable();
			$table->string('ios_link')->nullable();
			$table->string('terms')->nullable();
			$table->string('about_commission');
			$table->string('id_bank')->nullable();
			$table->decimal('commission', 8,2);
		});
	}

	public function down()
	{
		Schema::dropIfExists('settings');
	}
}