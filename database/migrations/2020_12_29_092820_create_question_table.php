<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->foreignId('list_id')->constrained('lists')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreignId('product_id')->nullable()->constrained('products')->references('id');
            $table->foreignId('rule_id')->nullable()->constrained('flow_rules')->references('id');

            $table->string('description')->nullable();
            $table->boolean('mandatory')->nullable();
            $table->string('question_type')->nullable();
            $table->integer('weight_question')->nullable();
            $table->boolean('has_action')->nullable();
            $table->string('link_video')->nullable();
            $table->integer('amount')->nullable();
            $table->string('ean_code')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('question');
    }
}
