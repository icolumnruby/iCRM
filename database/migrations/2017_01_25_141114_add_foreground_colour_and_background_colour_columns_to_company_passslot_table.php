<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForegroundColourAndBackgroundColourColumnsToCompanyPassslotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_passslot', function (Blueprint $table) {
          $table->string('foreground_colour');
          $table->string('background_colour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_passslot', function (Blueprint $table) {
            //
        });
    }
}