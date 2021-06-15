<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flow_chained_id')->constrained('flows');
            $table->foreignId('linked_list_id')->constrained('lists');
            $table->foreignId('question_id')->constrained('questions');
            $table->string('type_action')->nullable();
            $table->string('Description')->nullable();
            $table->string('trigger')->nullable();
            $table->string('trigger_rule')->nullable();
            $table->string('trigger_value')->nullable();
            $table->string('prefix_question_description')->nullable();
            $table->string('type_list')->nullable();
            $table->string('type_question')->nullable();
            $table->string('type_reference_list')->nullable();
            $table->string('list_tag')->nullable();
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
        Schema::dropIfExists('action');
    }
}
