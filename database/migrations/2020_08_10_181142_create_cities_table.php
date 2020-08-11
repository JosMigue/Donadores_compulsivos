<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('cities', function (Blueprint $table) {
        $table->integer('id')->increments()->primary();
        $table->integer('state_id')->nullable(false);
        $table->string('code',3)->nullable(false);
        $table->string('name')->nullable(false);
        $table->tinyInteger('active')->nullable(false);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
