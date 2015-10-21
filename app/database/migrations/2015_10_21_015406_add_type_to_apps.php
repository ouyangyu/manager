<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToApps extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('apps', function(Blueprint $table)
		{
            $table->string('apptype',255)->default('student');
            $table->string('equipment',255)->default('phone');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('apps', function(Blueprint $table)
		{
			//
		});
	}

}
