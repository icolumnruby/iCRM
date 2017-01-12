<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPassIdAgainColumnFromMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('members', function (Blueprint $table) {
             $table->dropColumn('pass_id');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('members', function (Blueprint $table) {
             $table->bigInteger('pass_id');
         });
     }
}
