<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyPassslotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_passslot', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('name');
            $table->integer('company_id');
            $table->integer('passslot_id');
            $table->string('name');
            $table->string('pass_ type');

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
        Schema::drop('company_passslot');
    }
}
