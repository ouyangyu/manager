<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassteacherTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classteacher', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('moodleid');
            $table->integer('classid');
            $table->integer('teacherid');
            $table->tinyInteger('enable')->default('1');
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
		Schema::drop('classteacher');
	}

}
