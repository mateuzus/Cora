<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateFlowRulesTable.
 */
class CreateFlowRulesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flow_rules', function(Blueprint $table) {
            $table->id();
            $table->foreignId('flow_id')->constrained('flows')->onDelete('CASCADE');

            $table->integer('order');
            $table->string('name');

            //temos que dizer para onde ele vai
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('CASCADE');
            $table->foreignId('store_id')->nullable()->constrained('stores')->onDelete('CASCADE');
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('CASCADE');
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('CASCADE');

            $table->string('type_action')->nullable();
            $table->string('question_type')->nullable();
            $table->string('trigger')->nullable();
            $table->string('trigger_rule')->nullable();
            //se deixar em branco escolher pelo "valeu" da fonte
            $table->string('trigger_value')->nullable();
            $table->boolean('use_network_config')->default(false);
            $table->string('rule')->nullable();

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
		Schema::drop('flow_rules');
	}
}
