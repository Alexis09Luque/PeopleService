<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dni');
            $table->string('names');
            $table->string('surname');
            $table->string('gender');
            $table->string('type');
            $table->string('institutional_email');
            $table->string('photo');
            $table->string('code');
            $table->integer('school_id');
            $table->string('phone');
            $table->string('mobile');
            $table->string('personal_email');
            $table->string('address');
            $table->string('description');
            
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
        Schema::dropIfExists('applicants');
    }
}
