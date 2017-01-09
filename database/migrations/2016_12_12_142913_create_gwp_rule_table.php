<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGwpRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gwp_rule', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('name');
            $table->string('description');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('max_same_day_receipt');
            $table->integer('total_quantity');
            $table->integer('daily_limit');
            $table->integer('contact_daily_limit');
            $table->integer('per_contact_limit');

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
