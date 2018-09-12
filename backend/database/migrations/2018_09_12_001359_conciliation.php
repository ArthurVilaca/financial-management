<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Conciliation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conciliation', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('issue_date')->nullable();

            $table->integer('banks_id')->unsigned()->nullable();
            $table->foreign('banks_id')->references('id')->on('banks');

            $table->integer('employees_id')->unsigned();
            $table->foreign('employees_id')->references('id')->on('employees');

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
        Schema::dropIfExists('conciliation');
    }
}
