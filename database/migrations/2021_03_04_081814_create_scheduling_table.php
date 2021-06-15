<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedulings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('creation_date')->nullable();
            $table->dateTime('last_execution_date')->nullable();
            $table->string('description')->nullable();
            $table->string('time')->nullable();
            $table->string('periodicity')->nullable();
            $table->string('status')->nullable();
            $table->string('type_scheduling')->nullable();
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
        Schema::dropIfExists('scheduling');
    }
}
