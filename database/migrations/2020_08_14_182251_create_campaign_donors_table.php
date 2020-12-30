<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignDonorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_donors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('campaign_id')->nullable(false);
            $table->integer('donor_id')->nullable(false);
            $table->boolean('donor_donated')->nullable(false)->default(0);
            $table->string('donation_date')->nullable(false)->default('0000-00-00 00:00:00');
            $table->integer('turn')->nullable(false);
            $table->time('time_turn')->nullable(false)->default('00:00');
            $table->string('ip_address')->nullable(false);
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
        Schema::dropIfExists('campaign_donors');
    }
}
