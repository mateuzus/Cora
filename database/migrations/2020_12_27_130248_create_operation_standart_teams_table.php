<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOperationStandartTeamsTable.
 */
class CreateOperationStandartTeamsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('operation_standart_teams', function(Blueprint $table) {
            $table->id();
            $table->foreignId('pop_id')->constrained('operation_standarts')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreignId('team_id')->constrained('teams')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
		Schema::drop('operation_standart_teams');
	}
}
