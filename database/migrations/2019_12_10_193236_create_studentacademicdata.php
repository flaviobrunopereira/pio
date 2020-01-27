<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateStudentacademicdata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_academic', function (Blueprint $table) {
            $table->biginteger('numSGA'); 
            $table->integer('curricularYear')->nullable();
	    $table->string('admissionDate')->nullable();
	    $table->boolean('mobility')->nullable();;
	    $table->string('lastLectiveYear')->nullable();
	    $table->string('conclusionDate')->nullable();
	    $table->string('studyCycle')->nullable();
            $table->string('courseCode')->nullable();
            $table->float('avgFinalGrade')->nullable();
            $table->string('admissionDescription')->nullable();
            $table->string('courseName')->nullable();
            $table->string('studyCycleCode')->nullable();
            $table->string('registrationDate')->nullable();
            $table->string('admissionLectiveYear')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_academic');
    }
}
