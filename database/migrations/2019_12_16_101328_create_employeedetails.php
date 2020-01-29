<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeedetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeedetails', function (Blueprint $table) {
            $table->integer('employeeNumber');
            $table->string('name');
            $table->string('gender')->nullable();
            $table->string('categoryProf')->nullable();
            $table->biginteger('nif');
            $table->string('type')->nullable()->nullable();
            $table->string('emailAlt')->nullable();
            $table->string('emailInst')->nullable();
            $table->string('voip')->nullable();
            $table->string('ouName');
            $table->string('career')->nullable();
            /*Qualificação Académica mais alta */
            $table->string('higherDegree')->nullable();
            $table->string('higherDegree_course')->nullable();
            $table->string('higherDegree_establishment')->nullable();
            $table->integer('higherDegree_codeOCDE')->nullable();
            $table->string('higherDegree_OCDE')->nullable();
            /*Last Qualificações Profissionais */
            $table->string('qualificationCode')->nullable();
            $table->string('qualificationTitle')->nullable();
            $table->string('qualificationDesc')->nullable();
            /* Ultimo serviço */
            $table->integer('lastServiceCode')->nullable();
            $table->string('lastServiceName')->nullable();
            $table->string('lastjobTitle')->nullable();
            $table->integer('lastServiceType')->nullable();
            /* Ultimo serviço ensino */
            $table->integer('lastTeachingserviceCode')->nullable();
            $table->string('lastTeachingServiceName')->nullable();
            $table->string('lastTeachingjobTitle')->nullable();
            $table->integer('lastTeachingServiceType')->nullable();
            $table->boolean('active');
            /* Time Stamps*/
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
        Schema::dropIfExists('employeedetails');
    }
}
