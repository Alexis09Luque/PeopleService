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
            $table->string('names',50);
            $table->string('surname',50);
            $table->integer('profile_id');
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone',10)->nullable();
            $table->string('mobile',9)->nullable();
            $table->string('address')->nullable();
            $table->string('email',100)->nullable()->unique();
            $table->string('photo',100)->nullable();
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
