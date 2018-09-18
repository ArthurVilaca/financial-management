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
            $table->double('number');
            $table->dateTime('expiration_date')->nullable();

            $table->integer('banks_id')->unsigned()->nullable();
            $table->foreign('banks_id')->references('id')->on('banks')->onDelete('cascade');

            $table->integer('clients_id')->unsigned();
            $table->foreign('clients_id')->references('id')->on('clients')->onDelete('cascade');

            $table->integer('providers_id')->unsigned();
            $table->foreign('providers_id')->references('id')->on('providers')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('projects_phases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('status');
            $table->dateTime('expiration_date')->nullable();
            $table->string('comments');
            $table->double('amount');
            $table->double('number');

            $table->integer('projects_id')->unsigned();
            $table->foreign('projects_id')->references('id')->on('projects')->onDelete('cascade');

            $table->integer('providers_id')->unsigned();
            $table->foreign('providers_id')->references('id')->on('providers')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('phases_billings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('status');
            $table->double('amount');
            $table->dateTime('due_date')->nullable();

            $table->integer('projects_phases_id')->unsigned();
            $table->foreign('projects_phases_id')->references('id')->on('projects_phases');

            $table->timestamps();
        });

        Schema::create('billsreceives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('comments');
            $table->string('status');
            $table->enum('type', ['COMUM', 'CREDITO'])->default('COMUM');
            $table->double('amount');
            $table->dateTime('due_date')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->double('discounts')->nullable();
            $table->double('additions')->nullable();

            $table->string('invoice_number')->nullable();  // numero nfe
            $table->dateTime('invoice_date')->nullable();

            $table->integer('employee_id')->unsigned()->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');

            $table->integer('banks_id')->unsigned()->nullable();
            $table->foreign('banks_id')->references('id')->on('banks');

            $table->integer('cost_centers_id')->unsigned()->nullable();
            $table->foreign('cost_centers_id')->references('id')->on('cost_centers');

            $table->integer('projects_id')->unsigned()->nullable();
            $table->foreign('projects_id')->references('id')->on('projects');

            $table->enum('conciliation', ['PENDENTE', 'REALIZADA'])->default('PENDENTE');

            $table->timestamps();
        });

        Schema::create('billspays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('comments');
            $table->string('status');
            $table->enum('type', ['COMUM', 'CREDITO', 'DEDUCOES'])->default('COMUM');
            $table->double('amount');
            $table->dateTime('due_date')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->double('discounts')->nullable();
            $table->double('additions')->nullable();            

            $table->string('invoice_number')->nullable();  // numero nfe
            $table->dateTime('invoice_date')->nullable();

            $table->integer('employee_id')->unsigned()->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');
            
            $table->integer('banks_id')->unsigned()->nullable();
            $table->foreign('banks_id')->references('id')->on('banks')->onDelete('cascade');

            $table->integer('cost_centers_id')->unsigned()->nullable();
            $table->foreign('cost_centers_id')->references('id')->on('cost_centers')->onDelete('cascade');

            $table->integer('projects_phases_id')->unsigned()->nullable();
            $table->foreign('projects_phases_id')->references('id')->on('projects_phases')->onDelete('cascade');

            $table->integer('projects_id')->unsigned()->nullable();
            $table->foreign('projects_id')->references('id')->on('projects')->onDelete('cascade');

            $table->integer('providers_id')->unsigned()->nullable();
            $table->foreign('providers_id')->references('id')->on('providers')->onDelete('cascade');

            $table->integer('billsreceives_id')->unsigned()->nullable();
            $table->foreign('billsreceives_id')->references('id')->on('billsreceives')->onDelete('cascade');

            $table->integer('numberInstallments')->nullable();
            $table->enum('conciliation', ['PENDENTE', 'REALIZADA'])->default('PENDENTE');

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
        Schema::dropIfExists('projects_phases');
        Schema::dropIfExists('providers');
        Schema::dropIfExists('billspay');
        Schema::dropIfExists('billsreceive');
    }
}
