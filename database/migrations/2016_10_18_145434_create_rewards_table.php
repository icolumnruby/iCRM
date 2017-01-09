<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->longtext('description')->nullable();
            $table->integer('company_id');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('quantity');
            $table->integer('points');
            $table->integer('daily_limit');
            $table->integer('monthly_limit');
            $table->integer('member_limit');
            $table->enum('is_active', ['Y', 'N'])->nullable();

            $table->bigInteger('created_by');
            $table->bigInteger('last_updated_by')->nullable();

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
        Schema::drop('rewards');
    }
}
