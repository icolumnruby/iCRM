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
            $table->string('name');
            $table->string('company_code');
            $table->string('description')->nullable();
            $table->integer('category_id');
            $table->integer('mobile');
            $table->enum('is_active', ['Y', 'N'])->nullable()->default('N');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->integer('country_id');
            $table->string('postal_code')->nullable();
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
