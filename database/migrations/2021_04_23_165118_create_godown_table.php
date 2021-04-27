<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGodownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('godown', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('godown_unique_id', 100);
            $table->string('details', 255);
            $table->string('latitude', 100);
            $table->string('longitude', 100);
            $table->string('address', 100);
            $table->string('status', 100);
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
        Schema::dropIfExists('godown');
    }
}
