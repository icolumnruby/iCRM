<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsRedemptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards_redemption', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('rewards_id');
            $table->integer('member_id');
            $table->integer('member_points_id');
            $table->integer('quantity');
            $table->integer('total_points');

            $table->bigInteger('created_by');
            $table->bigInteger('last_updated_by');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rewards_redemption');
    }
}
