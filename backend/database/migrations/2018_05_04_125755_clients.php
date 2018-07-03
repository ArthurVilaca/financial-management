<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Clients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('status', ['APROVADO', 'BLOQUEADO'])->default('BLOQUEADO');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('adress')->nullable();
            $table->string('adress_number')->nullable();
            $table->string('adress_complement')->nullable();
            $table->string('adress_district')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();

            $table->string('social_reason')->nullable();

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
        Schema::dropIfExists('clients');
    }
}
