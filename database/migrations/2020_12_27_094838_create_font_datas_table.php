<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFontDatasTable.
 */
class CreateFontDatasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('font_datas', function(Blueprint $table) {
            $table->id();
            $table->foreignId('network_id')->constrained('networks')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->string('type')->nullable();
            $table->string('name')->nullable();
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
		Schema::drop('font_datas');
	}
}
