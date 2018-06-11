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
            $table->enum('sector', ['ADMINISTRATIVO', 'FINANCEIRO', 'CAMPO', 'COMERCIAL', 'ANALISE'])->nullable();
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

            $table->dateTime('sunday_in')->nullable();
            $table->dateTime('sunday_out')->nullable();

            $table->dateTime('monday_in')->nullable();
            $table->dateTime('monday_out')->nullable();

            $table->dateTime('tuesday_in')->nullable();
            $table->dateTime('tuesday_out')->nullable();

            $table->dateTime('wednesday_in')->nullable();
            $table->dateTime('wednesday_out')->nullable();

            $table->dateTime('thursday_in')->nullable();
            $table->dateTime('thursday_out')->nullable();

            $table->dateTime('friday_in')->nullable();
            $table->dateTime('friday_out')->nullable();

            $table->dateTime('saturday_in')->nullable();
            $table->dateTime('saturday_out')->nullable();
            $table->enum('use_time_control', ['true', 'false'])->default('false');

            $table->dateTime('admission')->nullable();
            $table->dateTime('resignation')->nullable();
            $table->double('salary')->nullable();

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
