<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDonorAttendedToCampaignDonorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_donors', function ($table) {
            $table->boolean('donor_attended')->nullable(false)->default(0)->after('donor_donated');
            $table->text('reason_not_donation')->nullable(true)->default(null)->after('donor_attended');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
