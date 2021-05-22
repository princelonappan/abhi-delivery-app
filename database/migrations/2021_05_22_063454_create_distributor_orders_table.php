<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributor_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->nullable();
            $table->unsignedBigInteger('distributor_id')->nullable();
            $table->foreign('distributor_id')->references('id')->on('distributors')->onDelete('cascade');
            $table->string('status', 100)->default('Confirmed');
            $table->decimal('palet_order_total', 8, 2);
            $table->decimal('product_total', 15, 2)->nullable();
            $table->decimal('vat', 15, 2)->nullable();
            $table->decimal('vat_percentage', 15, 2);
            $table->decimal('delivery_charge', 15, 2);
            $table->decimal('delivery_charge_percentage', 15, 2);
            $table->decimal('delivery_charge_min_amount', 15, 2);
            $table->tinyInteger('payment_type')->comment('1 => COD, 2 => Card')->nullable();

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
        Schema::dropIfExists('distributor_orders');
    }
}
