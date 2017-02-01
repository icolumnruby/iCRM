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

            $table->integer('company_id');
            $table->integer('passslot_id');
            $table->string('name');
            $table->string('pass_type');
            $table->string('foreground_colour');
            $table->string('background_colour');
            $table->string('logo_url');
            $table->string('strip_url');

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
