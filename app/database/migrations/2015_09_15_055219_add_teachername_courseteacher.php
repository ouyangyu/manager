<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeachernameCourseteacher extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('courseteacher', function(Blueprint $table)
		{
			//
            $table->string('teachername',255)->default('教师');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('courseteacher', function(Blueprint $table)
		{
			//
		});
	}

}
