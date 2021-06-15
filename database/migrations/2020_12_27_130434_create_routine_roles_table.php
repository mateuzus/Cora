<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRoutineRolesTable.
 */
class CreateRoutineRolesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('routine_roles', function(Blueprint $table) {
            $table->id()->unsigned();
            $table->foreignId('role_id')->constrained('roles')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreignId('routine_id')->constrained('routines')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
		Schema::drop('routine_roles');
	}
}
