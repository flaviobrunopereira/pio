<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetrieveOUEnrolledStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('OUEnrolledStudents', function (Blueprint $table) {
	    $table->integer('numInt');
	    $table->biginteger('numSGA');
	    $table->string('studentName');
	    $table->string('emailAlt')->nullable();
	    $table->string('courseCode')->nullable();
	    $table->string('emailInt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('OUEnrolledStudents');
    }
}
