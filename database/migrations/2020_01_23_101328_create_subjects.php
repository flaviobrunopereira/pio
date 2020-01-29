<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->string('courseCode');
            $table->string('planCode');
            $table->string('branchCode');
            $table->string('subjectCode')->primary();
            $table->string('language');
            $table->string('subjectName');
            $table->integer('curricularYear');
            $table->string('period');
            $table->integer('ects');
            $table->string('mandatory');
            $table->string('internship');
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
        Schema::dropIfExists('subjects');
    }
}
