<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorPaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributor_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('distributor_order_id')->nullable();
            $table->foreign('distributor_order_id')->references('id')->on('distributor_orders');
            $table->string('payment_transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributor_payment_transactions');
    }
}
