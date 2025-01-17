<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Taxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->double('amount');
            $table->string('description');

            $table->enum('collection', ['R$', '%'])->default('%');
            $table->enum('type', ['FEDERAL', 'MUNICIPAL', 'ESTADUAL'])->default('FEDERAL');
            $table->enum('reference', ['RECEITA', 'DESPESA'])->default('RECEITA');

            $table->dateTime('due_date')->nullable();

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
        Schema::dropIfExists('taxes');
    }
}
