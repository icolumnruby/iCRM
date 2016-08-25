<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsCustomerMetaValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_customer_meta_value', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('client_customer_id');
            $table->bigInteger('meta_id');
            $table->string('meta_value');

            $table->foreign('client_customer_id')->references('id')->on('clients_customer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients_customer');
    }
}
