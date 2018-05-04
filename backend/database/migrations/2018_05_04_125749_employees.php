<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Employees extends Migration
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
            $table->string('username')->nullable();
            $table->string('name');
            $table->string('password');
            $table->string('sector')->nullable();
            $table->enum('status', ['APROVADO', 'BLOQUEADO'])->default('BLOQUEADO');
            $table->string('token')->nullable();
            $table->dateTime('expiration_date')->nullable();
            $table->string('ip')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('adress')->nullable();
            $table->string('adress_number')->nullable();
            $table->string('adress_complement')->nullable();
            $table->string('adress_district')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();

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
