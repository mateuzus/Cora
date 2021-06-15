<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRoutinesTable.
 */
class CreateRoutinesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('routines', function(Blueprint $table) {
            $table->id();
            $table->foreignId('network_id')->constrained('networks')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreignId('font_data_id')->constrained('font_datas')->onUpdate('NO ACTION')->onDelete('CASCADE');

            $table->string('name')->nullable();
            $table->string('schedule')->nullable();
            $table->integer('day')->nullable();
            $table->time('time')->nullable();
            $table->string('image')->nullable();
            $table->longText('description')->nullable();

            $table->integer('duration_days')->nullable();
            $table->integer('duration_hours')->nullable();
            $table->integer('duration_minutes')->nullable();
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
		Schema::drop('routines');
	}
}
