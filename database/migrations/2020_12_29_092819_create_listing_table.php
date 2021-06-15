<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lists', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->foreignId('user_id')->constrained('users')->references('id');
            $table->foreignId('network_id')->constrained('networks')->references('id');
            $table->foreignId('store_id')->constrained('stores')->references('id');
            $table->foreignId('department_id')->constrained('departments')->references('id');
            $table->foreignId('team_id')->constrained('teams')->references('id');
            $table->foreignId('flow_id')->nullable()->constrained('flows')->references('id');
            $table->foreignId('flow_rule_id')->nullable()->constrained('flow_rules')->references('id');
            $table->foreignId('pop_id')->nullable()->constrained('operation_standarts')->onDelete('CASCADE');
            $table->foreignId('routine_id')->nullable()->constrained('routines')->onDelete('CASCADE');
            $table->string('description')->nullable();
            $table->date('creation_date')->nullable();
            $table->string('type')->nullable();
            $table->char('status', 1)->nullable();
            $table->string('list_tag')->nullable();
            $table->dateTime('period_start')->nullable();
            $table->dateTime('period_end')->nullable();
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
        Schema::dropIfExists('lists');
    }
}
