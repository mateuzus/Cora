<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFontDataDetailsTable.
 */
class CreateFontDataDetailsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('font_data_details', function(Blueprint $table) {
            $table->id();
            $table->foreignId('font_data_id')->constrained('font_datas')->onUpdate('NO ACTION')->onDelete('CASCADE');

            //usuário poderá digitar se for do tipo manual
            $table->string('ean_code')->nullable();
            $table->string('description')->nullable();
            $table->decimal('value')->nullable();

            //url somente será valida se for api se for do tipo csv inserir um botão para upload do arquivo
            $table->string('url')->nullable();


            //se for api nunca marcar como utilizado
            //se for arquivo ou digitação livre após o consumo no flow ou pop ou rotina -  marcar como utilizado
            $table->boolean('status');//0-não utilizado //1-utilizadado
            $table->dateTime('utilized_at')->nullable();

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
		Schema::drop('font_data_details');
	}
}
