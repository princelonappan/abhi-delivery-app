<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeginKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('branches', function (Blueprint $table) {
            $table->foreign('distributor_id')->references('id')->on('distributors')->onDelete('cascade');
        });
        Schema::table('carts', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('product_images', function (Blueprint $table) {
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
        // Schema::table('branches', function (Blueprint $table) {
        //     $table->dropForeign('branches_distributor_id_foreign');
        // });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign('carts_customer_id_foreign');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign('cart_items_cart_id_foreign');
            $table->dropForeign('cart_items_product_id_foreign');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign('order_items_order_id_foreign');
            $table->dropForeign('order_items_product_id_foreign');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_customer_id_foreign');
        });

        // Schema::table('products', function (Blueprint $table) {
        //     $table->dropForeign('products_category_id_foreign');
        // });

        Schema::table('product_images', function (Blueprint $table) {
            $table->dropForeign('product_images_product_id_foreign');
        });
    }
}
