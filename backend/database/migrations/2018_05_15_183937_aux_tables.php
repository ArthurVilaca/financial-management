<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AuxTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->string('account')->nullable();
            $table->string('agency')->nullable();
            $table->string('contact')->nullable();
            $table->string('manager')->nullable();
            $table->string('telephone')->nullable();

            $table->string('adress')->nullable();
            $table->string('adress_number')->nullable();
            $table->string('adress_complement')->nullable();
            $table->string('adress_district')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();

            $table->timestamps();
        });

        Schema::create('cost_centers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type')->nullable();

            $table->integer('cost_centers_id')->unsigned()->nullable();
            $table->foreign('cost_centers_id')->references('id')->on('cost_centers');

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
        Schema::dropIfExists('banks');
        Schema::dropIfExists('cost_centers');
    }
}
