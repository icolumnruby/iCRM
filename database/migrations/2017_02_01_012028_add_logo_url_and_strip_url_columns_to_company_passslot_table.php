<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLogoUrlAndStripUrlColumnsToCompanyPassslotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_passslot', function (Blueprint $table) {
          $table->string('logo_url');
          $table->string('strip_url');
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
