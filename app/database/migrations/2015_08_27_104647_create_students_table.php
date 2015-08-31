<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('moodleid');
            $table->integer('studentid');
            $table->string('username', 255);
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 50)->default("");
            $table->boolean('isdelete')->default(0);
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
		Schema::drop('students');
	}

}
