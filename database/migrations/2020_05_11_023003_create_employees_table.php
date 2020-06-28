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
            $table->integer('profile_id');
            $table->date('date_of_birth')->nullable();//cambiar a date 
            $table->string('gender')->nullable();
            $table->string('phone',10)->nullable();
            $table->string('address')->nullable();
            $table->string('email',100)->nullable()->unique();

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
