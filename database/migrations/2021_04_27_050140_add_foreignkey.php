<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignkey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('palet_inventory', function (Blueprint $table) {
            $table->foreign('godown_id')->references('id')->on('godown')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('palet_inventory', function (Blueprint $table) {
            $table->dropForeign('palet_inventory_godown_id_foreign');
            $table->dropForeign('palet_inventory_product_id_foreign');
        });
    }
}
