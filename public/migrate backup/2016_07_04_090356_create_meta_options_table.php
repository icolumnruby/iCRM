<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_options', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('meta_id');
            $table->string('option');
            $table->integer('rank');
            $table->integer('is_activated');

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
        Schema::drop('meta_options');
    }
}
