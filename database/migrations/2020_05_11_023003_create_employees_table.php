<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dni',8)->unique();
            $table->string('code')->nullable();
            $table->string('names');
            $table->string('surname');
            $table->string('profile');
            $table->string('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();

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
        Schema::dropIfExists('employees');
    }
}
