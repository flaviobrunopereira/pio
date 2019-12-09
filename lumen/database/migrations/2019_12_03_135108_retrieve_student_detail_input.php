<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RetrieveStudentDetailInput extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retrieveStudentDetail', function (Blueprint $table) {
            $table->integer('numInt');
            $table->biginteger('numSGA');
            $table->string('name');
            $table->string('courseCode')->nullable();
            $table->string('course')->nullable();
            $table->string('status');
            $table->string('emailInt')->nullable();
            $table->string('emailAlt')->nullable();
            $table->text('photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retrieveStudentDetail');
    }
}
