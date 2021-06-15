<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateDepartmentsTable.
 */
class CreateDepartmentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('departments', function(Blueprint $table) {
            $table->id();
            $table->foreignId('network_id')->constrained('networks')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->string('code');
            $table->string('name');
            $table->boolean('status')->nullable();
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
		Schema::drop('departments');
	}
}
