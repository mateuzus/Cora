<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFlowStoresTable.
 */
class CreateFlowStoresTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flow_stores', function(Blueprint $table) {
            $table->id();
            $table->foreignId('flow_id')->constrained('flows')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
		Schema::drop('flow_stores');
	}
}
