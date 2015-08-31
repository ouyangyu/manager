<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseteacherTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courseteacher', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('moodleid');
            $table->integer('courseid');
            $table->integer('teacherid');
            $table->tinyInteger('enable')->default('1');
            $table->softDeletes();
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
     *
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('courseteacher');
	}

}
