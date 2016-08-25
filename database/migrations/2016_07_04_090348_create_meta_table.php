<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->integer('type');
            $table->integer('rank')->nullable();
            $table->enum('multiselect', ['Y', 'N'])->nullable();
            $table->integer('min_length')->nullable();
            $table->integer('max_length')->nullable();
            $table->string('options')->nullable();
            $table->string('date_format')->nullable();
            $table->enum('is_mandatory', ['Y', 'N'])->nullable()->default('N');
            $table->string('mandatory_msg')->nullable();
            $table->string('summary')->nullable();
            $table->mediumText('description')->nullable();
            $table->enum('is_activated', ['Y', 'N'])->default('Y');
            $table->integer('created_by');
            $table->integer('last_updated_by');

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
        Schema::drop('meta');
    }
}
