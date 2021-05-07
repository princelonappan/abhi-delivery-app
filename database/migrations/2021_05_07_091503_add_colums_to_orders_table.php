<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('product_total', 15, 2)->nullable()->after('order_total');
            $table->decimal('vat', 15, 2)->nullable()->after('product_total');
            $table->decimal('vat_percentage', 15, 2)->nullable()->after('vat');
            $table->decimal('delivery_charge', 15, 2)->nullable()->after('vat_percentage');
            $table->decimal('delivery_charge_percentage', 15, 2)->nullable()->after('delivery_charge');
            $table->decimal('delivery_charge_min_amount', 15, 2)->nullable()->after('delivery_charge_percentage');
            $table->tinyInteger('payment_type')->comment('1 => COD, 2 => Card')->nullable()->after('delivery_charge_min_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
