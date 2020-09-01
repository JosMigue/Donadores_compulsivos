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
            $table->string('parental_surname')->nullable(false);
            $table->string('maternal_surname')->nullable(false);
            $table->string('address')->nullable(false);
            $table->string('postal_code')->nullable(false);
            $table->integer('city_id')->nullable(false); 
            $table->integer('state_id')->nullable(false); 
            $table->string('bloodtype')->nullable(false);
            $table->string('donortype')->nullable(false);
            $table->string('gendertype')->nullable(false);
            $table->date('born_date')->nullable(false);
            $table->boolean('first_time_donating')->default(true)->nullable(false);
            $table->integer('age')->nullable(false);
            $table->string('email')->nullable(true);
            $table->double('weight')->nullable(false);
            $table->double('height')->nullable(false);
            $table->string('mobile')->nullable(true);
            $table->integer('user_id')->nullable(false);
            $table->string('last_donate_date')->nullable(true);
            $table->string('observations')->nullable(true);
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
