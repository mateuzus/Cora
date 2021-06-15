<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateOperationStandardsTable.
 */
class CreateOperationStandartTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('operation_standarts', function(Blueprint $table) {
            $table->id();
            $table->foreignId('network_id')->constrained('networks')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreignId('flow_id')->constrained('flows')->onUpdate('NO ACTION')->onDelete('CASCADE');

            $table->string('code')->nullable();
            $table->string('sector')->nullable();
            $table->string('name')->nullable();
            $table->text('target')->nullable();
            $table->text('references')->nullable();
            $table->text('material')->nullable();

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
		Schema::drop('operation_standart');
	}
}
