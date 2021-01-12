<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporalDonorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporal_donors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
            $table->string('parental_surname')->nullable(false);
            $table->string('maternal_surname')->nullable(true);
            $table->string('curp',18)->nullable(true)->default(null);
            $table->integer('city_id')->nullable(false); 
            $table->integer('state_id')->nullable(false); 
            $table->string('bloodtype')->nullable(false);
            $table->string('donortype')->nullable(false);
            $table->string('gendertype')->nullable(true)->default(null);
            $table->date('born_date')->nullable(false);
            $table->boolean('first_time_donating')->default(false)->nullable(false);
            $table->boolean('be_the_match')->default(false)->nullable(false);
            $table->boolean('letter')->default(false)->nullable(false);
            $table->integer('age')->nullable(false);
            $table->string('email')->nullable(true);
            $table->string('mobile')->nullable(true);
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
        Schema::dropIfExists('temporal_donors');
    }
}
