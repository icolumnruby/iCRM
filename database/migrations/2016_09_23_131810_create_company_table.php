<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('brand_name');
            $table->string('company')->nullable();
            $table->string('fullname');
            $table->integer('mobile');
            $table->string('email');
            $table->string('comments')->nullable();
            $table->enum('is_active', ['Y', 'N'])->nullable()->default('N');
            $table->string('address')->nullable();
            $table->integer('country_id');
            $table->integer('passslot_template_id');

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
        Schema::drop('company');
    }
}
