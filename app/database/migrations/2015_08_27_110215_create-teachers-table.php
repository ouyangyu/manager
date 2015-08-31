<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('teachers', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('moodleid');
            $table->string('teacher', 255)->unique();
            $table->string('password', 64);
            $table->string('name', 255);
            $table->string('image', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('nativeplace',255)->nullable();
            $table->string('nation',255)->nullable();
            $table->string('major',255)->nullable();
            $table->string('identity',255)->nullable();
            $table->string('education',255)->nullable();
            $table->tinyInteger('type')->default('1');
            $table->softDeletes();
            $table->tinyInteger('sex')->default('1');

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
		Schema::drop('teachers');
	}

}
