<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientTaxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_taxes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('clients_id')->unsigned();
            $table->foreign('clients_id')->references('id')->on('clients');

            $table->integer('taxes_id')->unsigned();
            $table->foreign('taxes_id')->references('id')->on('taxes');

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
        Schema::dropIfExists('client_taxes');
    }
}
