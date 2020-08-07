<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
            $table->string('address')->nullable(false);
            $table->integer('city_id')->nullable(false); 
            $table->integer('state_id')->nullable(false); 
            $table->string('blood_type')->nullable(false);
            $table->date('born_date')->nullable(false);
            $table->integer('age')->nullable(false);
            $table->double('weight')->nullable(false);
            $table->double('height')->nullable(false);
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
        Schema::dropIfExists('donors');
    }
}
