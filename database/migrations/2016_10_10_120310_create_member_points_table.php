<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_points', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('member_id');
            $table->integer('points');
            $table->integer('points_balance');
            $table->string('remarks')->nullable();

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
        Schema::drop('member_points');
    }
}
