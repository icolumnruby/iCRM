<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('salutation');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('nric')->unique();
            $table->boolean('gender');
            $table->string('mobile_country_code');
            $table->string('mobile');
            $table->string('email');
            $table->date('birthdate');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->integer('country_id');
            $table->string('postal_code')->nullable();
            $table->integer('nationality_id');
            $table->enum('is_member', ['Y', 'N'])->nullable();
            $table->string('member_type')->nullable();
            $table->integer('company_id')->nullable();

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
        Schema::drop('contacts');
    }
}
