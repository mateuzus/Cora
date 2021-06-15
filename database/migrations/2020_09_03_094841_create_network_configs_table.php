<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateNetworkConfigsTable.
 */
class CreateNetworkConfigsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('network_configs', function(Blueprint $table) {
            $table->increments('id');
            $table->foreignId('network_id')->constrained('networks')->onUpdate('NO ACTION')->onDelete('CASCADE');
//            $table->string('bg_color')->nullable();
//            $table->string('network_logo')->nullable();
            $table->decimal('price_lowering_rules')->nullable();
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
		Schema::drop('network_configs');
	}
}
