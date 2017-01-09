<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoyaltyConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyalty_config', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('member_type_id');
            $table->string('name');
            $table->longtext('description')->nullable();
            $table->integer('company_id');
            $table->integer('action_id');  //purchase, signup, renewal
            $table->string('type');
            $table->string('expiry');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('points');
            $table->integer('value');
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
        Schema::drop('loyalty_config');
    }
}
