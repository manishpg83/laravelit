<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('recently_view', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->unsigned();
            $table->string('session_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recently_view');
    }
};
