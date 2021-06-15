<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOperationStandartRolesTable.
 */
class CreateOperationStandartRolesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('operation_standart_roles', function(Blueprint $table) {
            $table->id();
            $table->foreignId('pop_id')->constrained('operation_standarts')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreignId('role_id')->constrained('roles')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
		Schema::drop('operation_standart_roles');
	}
}
