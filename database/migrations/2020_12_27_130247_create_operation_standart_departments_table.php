<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateOperationStandartDepartmentsTable.
 */
class CreateOperationStandartDepartmentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('operation_standart_departments', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('pop_id')->unsigned()->nullable();
            $table->foreign('pop_id')->references('id')->on('operation_standarts')->onDelete('cascade');
            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
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
		Schema::drop('operation_standart_departments');
	}
}
