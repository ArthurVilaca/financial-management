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

            $table->timestamps();
        });

        Schema::create('cost_centers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type')->nullable();

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
