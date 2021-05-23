<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToPaletInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('palet_inventory', function (Blueprint $table) {
            $table->unsignedBigInteger('distributor_order_id')->nullable()->after('palet_id');;
            $table->foreign('distributor_order_id')->references('id')->on('distributor_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('palet_inventory', function (Blueprint $table) {
            $table->dropColumn('distributor_order_id');
        });
    }
}
