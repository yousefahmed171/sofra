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
			$table->string('facebook_link');
			$table->string('instagram_link');
			$table->string('twitter_link');
			$table->string('youtube_link');
			$table->string('whatsapp_link');
			$table->string('android_link');
			$table->string('ios_link');
			$table->string('terms')->nullable();
			$table->string('about_commission');
			$table->string('id_bank');
		});
	}

	public function down()
	{
		Schema::dropIfExists('settings');
	}
}