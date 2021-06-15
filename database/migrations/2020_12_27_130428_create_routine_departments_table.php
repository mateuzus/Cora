<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRoutineDepartmentsTable.
 */
class CreateRoutineDepartmentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('routine_departments', function(Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments')->on('departments')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreignId('routine_id')->constrained('routines')->on('routines')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
		Schema::drop('routine_departments');
	}
}
