<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_contacts', function (Blueprint $table) {
            $table->string('name');
            $table->string('emailInt')->nullable();
            $table->string('emailAlt')->nullable();
            $table->string('civilState')->nullable();
            $table->string('gender')->nullable();
            $table->string('birthDate')->nullable();
            $table->string('identification')->nullable();
            $table->bigInteger('nif')->nullable();
            $table->string('residence')->nullable();
            $table->string('postCode')->nullable();
            $table->string('locale')->nullable();
	    $table->string('placeOfBirth')->nullable();
	    $table->string('nationality')->nullable();
	    $table->string('phone')->nullable();
	    $table->string('mobilePhone')->nullable();
	    $table->string('allowNotifications')->nullable();
	    $table->string('photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_contacts');
    }
}
