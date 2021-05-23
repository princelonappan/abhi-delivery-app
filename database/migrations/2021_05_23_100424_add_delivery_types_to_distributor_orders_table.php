<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryTypesToDistributorOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributor_orders', function (Blueprint $table) {
            $table->integer('delivery_type')->default(1)->nullable()->after('payment_type')->comment('1 => Deliver by Address, 2 => Pickup from Godown');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distributor_orders', function (Blueprint $table) {
            //
        });
    }
}
