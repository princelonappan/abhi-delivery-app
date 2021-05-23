<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPaletFullToDistributorOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distributor_order_items', function (Blueprint $table) {
            $table->integer('is_palet_full')->default(0)->nullable()->after('price')->comment('1 => false, 2 => true');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distributor_order_items', function (Blueprint $table) {
            $table->dropColumn('is_palet_full');
        });
    }
}
