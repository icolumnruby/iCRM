<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('clients_customer_id');
            $table->string('payment_mode');
            $table->string('payment_type');
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->string('transaction_no');
            $table->dateTime('purchase_date');
            $table->string('remarks');
            $table->bigInteger('last_updated_by');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('clients_customer_id')->references('id')->on('clients_customer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transactions');
    }
}
