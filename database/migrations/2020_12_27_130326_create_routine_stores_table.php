<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRoutineStoresTable.
 */
class CreateRoutineStoresTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('routine_stores', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('routines_id')->unsigned();
            $table->foreign('routines_id')->references('id')->on('routines')->onDelete('cascade');
            $table->bigInteger('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
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
		Schema::drop('routine_stores');
	}
}
