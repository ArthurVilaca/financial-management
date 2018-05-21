<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Projects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('notes');
            $table->string('status');
            $table->double('amount');

            $table->integer('clients_id')->unsigned();
            $table->foreign('clients_id')->references('id')->on('clients');

            $table->timestamps();
        });

        Schema::create('projects_providers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('projects_id')->unsigned();
            $table->foreign('projects_id')->references('id')->on('projects');

            $table->integer('providers_id')->unsigned();
            $table->foreign('providers_id')->references('id')->on('providers');

            $table->timestamps();
        });

        Schema::create('projects_phases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('status');            
            $table->dateTime('expiration_date')->nullable();

            $table->integer('projects_id')->unsigned();
            $table->foreign('projects_id')->references('id')->on('projects');

            $table->integer('providers_id')->unsigned();
            $table->foreign('providers_id')->references('id')->on('providers');

            $table->timestamps();
        });

        Schema::create('billspay', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('comments');
            $table->string('status');
            $table->double('amount');

            $table->integer('projects_phases_id')->unsigned();
            $table->foreign('projects_phases_id')->references('id')->on('projects_phases');

            $table->timestamps();
        });

        Schema::create('billsreceive', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('comments');
            $table->string('status');
            $table->double('amount');

            $table->integer('projects_id')->unsigned();
            $table->foreign('projects_id')->references('id')->on('projects');

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
        Schema::dropIfExists('projects');
        Schema::dropIfExists('projects_providers');
        Schema::dropIfExists('projects_phases');
        Schema::dropIfExists('billspay');
        Schema::dropIfExists('billsreceive');
    }
}
