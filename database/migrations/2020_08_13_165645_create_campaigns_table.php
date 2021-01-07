<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
            $table->string('place')->nullable(true)->default(null);
            $table->string('description')->nullable(true)->default(null);
            $table->integer('city_id')->nullable(false);
            $table->integer('state_id')->nullable(false);
            $table->string('date_start')->nullable(false);
            $table->string('time_start')->nullable(false);
            $table->string('date_finish')->nullable(false);
            $table->string('time_finish')->nullable(false);
            $table->string('campaigntype')->nullable(false);
            $table->integer('blood_bank_id')->nullable(true)->default(null);
            $table->integer('frecuency')->nullable(true)->default(1);
            $table->integer('frecuency_time')->nullable(true)->default(10);
            $table->integer('user_id')->nullable(false);
            $table->string('campaign_image')->nullable(false);
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
        Schema::dropIfExists('campaigns');
    }
}
