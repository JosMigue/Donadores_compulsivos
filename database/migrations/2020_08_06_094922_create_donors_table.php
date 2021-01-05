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
            $table->integer('identifier')->nullable(true)->default(0);
            $table->string('name')->nullable(false);
            $table->string('parental_surname')->nullable(false);
            $table->string('maternal_surname')->nullable(true);
            $table->string('curp',20)->nullable(true)->default(null);
            $table->string('postal_code')->nullable(true)->default(null);
            $table->string('address')->nullable(true)->default(null);
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
            $table->integer('user_id')->nullable(false);
            $table->string('last_donate_date')->nullable(true);
            $table->string('observations')->nullable(true);
            $table->string('profile_picture')->nullable(true);
            $table->text('signature')->nullable(true);
            $table->boolean('is_active')->default(1)->nullable(false);
            $table->boolean('is_temporal')->default(0)->nullable(false);
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
