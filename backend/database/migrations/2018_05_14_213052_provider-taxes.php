<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProviderTaxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_taxes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('providers_id')->unsigned();
            $table->foreign('providers_id')->references('id')->on('providers');

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
        Schema::dropIfExists('provider_taxes');
    }
}
