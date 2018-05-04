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
            $table->string('sector');
            $table->enum('status', ['APROVADO', 'BLOQUEADO'])->default('BLOQUEADO');
            $table->string('token')->nullable();
            $table->dateTime('expiration_date')->nullable();
            $table->string('ip')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('adress');
            $table->string('adress_number');
            $table->string('adress_complement');
            $table->string('adress_district');
            $table->string('zip_code');
            $table->string('city');
            $table->string('state');

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
