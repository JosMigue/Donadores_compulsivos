<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('states', function (Blueprint $table) {
        $table->integer('id')->primary()->increments();
        $table->string('code',2)->nullable(false)->unique();
        $table->string('name')->nullable(false);
        $table->string('abbreviation')->nullable(false);
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
        Schema::dropIfExists('states');
    }
}
