<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIsdeleteToMoodle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('moodle', function(Blueprint $table)
		{
			//
            $table->dropColumn('isdelete');
            $table->boolean('istotal')->default(0);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('moodle', function(Blueprint $table)
		{
			//
		});
	}

}
