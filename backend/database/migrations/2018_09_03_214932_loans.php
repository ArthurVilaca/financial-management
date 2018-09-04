<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Loans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->double('amount')->nullable();
            $table->double('interest')->nullable();
            $table->double('admin_taxes')->nullable();

            $table->double('value_plots')->nullable();
            $table->double('plots')->nullable();

            $table->dateTime('issue_date')->nullable();
            $table->dateTime('due_date')->nullable();

            $table->integer('banks_id')->unsigned()->nullable();
            $table->foreign('banks_id')->references('id')->on('banks');

            $table->timestamps();
        });

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();

            $table->timestamps();
        });

        Schema::create('bank_reconciliation', function (Blueprint $table) {
            $table->increments('id');

            $table->dateTime('issue_date')->nullable();
            $table->string('reconciled_value')->nullable();
            $table->string('left_value')->nullable();

            $table->timestamps();
        });

        Schema::create('clients_comments', function (Blueprint $table) {
            $table->increments('id');

            $table->string('comments')->nullable();

            $table->integer('clients_id')->unsigned();
            $table->foreign('clients_id')->references('id')->on('clients');

            $table->integer('employees_id')->unsigned()->nullable();
            $table->foreign('employees_id')->references('id')->on('employees');

            $table->timestamps();
        });

        Schema::create('providers_comments', function (Blueprint $table) {
            $table->increments('id');

            $table->string('comments')->nullable();

            $table->integer('providers_id')->unsigned();
            $table->foreign('providers_id')->references('id')->on('providers');

            $table->integer('employees_id')->unsigned()->nullable();
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
        Schema::dropIfExists('loans');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('bank_reconciliation');
        Schema::dropIfExists('clients_comments');
        Schema::dropIfExists('providers_comments');
    }
}
