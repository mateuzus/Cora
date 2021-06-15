<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOperationStandartStoresTable.
 */
class CreateOperationStandartStoresTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('operation_standart_stores', function(Blueprint $table) {
            $table->id();
            $table->foreignId('pop_id')->constrained('operation_standarts')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreignId('store_id')->constrained('stores')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
		Schema::drop('operation_standart_stores');
	}
}
