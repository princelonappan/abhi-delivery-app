<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGodownZipCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('godown_zip_code', function (Blueprint $table) {
            $table->id();
            $table->foreignId('godown_id');
            $table->string('zip_code', 50)->unique();
            $table->timestamps();

            $table->foreign('godown_id')->references('id')->on('godown');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('godown_zip_code');
    }
}
