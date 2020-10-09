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
            $table->string('dni',8)->unique();
            $table->string('names',50);
            $table->string('surname',50);
            $table->string('gender');
            $table->string('type');
            $table->string('institutional_email',100)->nullable()->unique();
            $table->string('photo')->nullable();
            $table->string('code')->nullable();
            $table->integer('school_id')->nullable();
            $table->string('phone',10)->nullable();
            $table->string('mobile',9)->nullable();
            $table->string('personal_email',100)->nullable()->unique();
            $table->string('address')->nullable();
            $table->string('description',200)->nullable();
            
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
