<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassuserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classuser', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('moodleid');
            $table->integer('classid');
            $table->integer('studentid');
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
		Schema::drop('classuser');
	}

}
