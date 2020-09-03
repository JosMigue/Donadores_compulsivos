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
            $table->integer('turn')->nullable(false);
            $table->string('ip_address')->nullable(false);
            $table->timestamps();;
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
