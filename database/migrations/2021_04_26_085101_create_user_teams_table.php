<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserTeamsTable.
 */
class CreateUserTeamsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_teams', function(Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreignId('team_id')->constrained('teams')->onUpdate('NO ACTION')->onDelete('NO ACTION');

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
		Schema::drop('user_teams');
	}
}
