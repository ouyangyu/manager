<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoodlecourseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moodlecourse', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('mmoodleid');
            $table->integer('mcourseid');
            $table->integer('bmoodleid');
            $table->integer('bcourseid');
            $table->softDeletes();
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('moodlecourse');
	}

}
