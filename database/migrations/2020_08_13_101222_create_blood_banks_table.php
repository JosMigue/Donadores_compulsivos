<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
            $table->string('address')->nullable(false);
            $table->string('extension_number')->nullable(true)->default(null);
            $table->string('phone')->nullable(false);
            $table->string('contact_person')->nullable(false);
            $table->string('contact_person_mobile')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('postal_code')->nullable(false);
            $table->integer('city_id')->nullable(false);
            $table->integer('state_id')->nullable(false);
            $table->integer('user_id')->nullable(false);
            $table->string('days',2000)->nullable(false);
            $table->string('hyperlink')->nullable(true)->default(null);
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
        Schema::dropIfExists('blood_banks');
    }
}
