<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeletedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deletedStudents', function (Blueprint $table) {
            $table->integer('numInt');
            $table->biginteger('numSGA');
            $table->string('studentName');
            $table->string('emailAlt')->nullable();
            $table->string('courseCode')->nullable();
            $table->string('emailInt')->nullable();
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
