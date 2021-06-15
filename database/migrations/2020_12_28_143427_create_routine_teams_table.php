<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRoutineTeamsTable.
 */
class CreateRoutineTeamsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('routine_teams', function(Blueprint $table) {
            $table->id();
            $table->foreignId('routine_id')->constrained('routines')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
		Schema::drop('routine_teams');
	}
}
