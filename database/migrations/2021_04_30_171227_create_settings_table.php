<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2)->nullable();
            $table->integer('no_days')->nullable();
            $table->decimal('min_amount', 15, 2)->nullable();
            $table->integer('type')->comment('1 => Fixed, 2 => Percentage')->nullable();
            $table->integer('cash_on_delivery')->comment('1 => Enabled, 0 => Disabled')->nullable();
            $table->integer('card_payment')->comment('1 => Enabled, 0 => Disabled')->nullable();
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
