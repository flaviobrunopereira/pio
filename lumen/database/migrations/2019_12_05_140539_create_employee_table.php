<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->integer('employeeNumber');
            $table->string('name');
            $table->string('professionalCategory');
            $table->boolean('teacher');
            $table->boolean('phd');
            $table->string('emailInst')->nullable();
            $table->string('identification');
            $table->string('identificationType');
            $table->string('nationality')->nullable();
            $table->string('nif');
            $table->string('gender');
            $table->date('birthDate')->nullable();
        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
