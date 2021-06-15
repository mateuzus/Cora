<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFlowTeamsTable.
 */
class CreateFlowTeamsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flow_teams', function(Blueprint $table) {
            $table->increments('id');
            $table->foreignId('flow_id')->constrained('flows')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
		Schema::drop('flow_teams');
	}
}
