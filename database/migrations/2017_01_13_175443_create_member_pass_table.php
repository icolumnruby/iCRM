<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberPassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_pass', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('member_id');
            $table->string('pass_serial_number');
            $table->string('pass_type_id');
            $table->string('pass_url');

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
        Schema::drop('member_pass');
    }
}
