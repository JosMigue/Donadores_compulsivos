<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividualDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_donations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bloodbank_id');
            $table->integer('donor_id');
            $table->date('date_donation');
            $table->time('time_donation');
            $table->string('donationtype');
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
        Schema::dropIfExists('individual_donations');
    }
}
