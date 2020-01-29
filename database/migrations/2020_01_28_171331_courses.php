<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Courses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->string('courseCode');
            $table->integer('degreeCode');
            $table->string('coursePublic');
            $table->integer('codeDGES');
            $table->string('degree');
            $table->string('language');
            $table->string('frequencyRegime');
            $table->string('duration');
            $table->string('courseName');
            $table->string('ects');
            $table->boolean('courseActive');
            $table->string('normalizedDegreeCode');
            $table->string('codeCNAEF')->nullable();
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
        //
    }
}
