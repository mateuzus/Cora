<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRoutineTasksTable.
 */
class CreateRoutineTasksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('routine_tasks', function(Blueprint $table) {
            $table->id();
            $table->foreignId('routine_id')->constrained('routines')->onUpdate('NO ACTION')->onDelete('CASCADE');

            $table->string('description')->nullable();
            $table->boolean('required')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('weight')->nullable();
            $table->boolean('has_action')->nullable();
            $table->string('video')->nullable();
            $table->string('quantity')->nullable();
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
		Schema::drop('routine_tasks');
	}
}
