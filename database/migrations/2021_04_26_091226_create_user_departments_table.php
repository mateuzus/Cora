<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserDepartmentsTable.
 */
class CreateUserDepartmentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_departments', function(Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreignId('department_id')->constrained('departments')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
		Schema::drop('user_departments');
	}
}
