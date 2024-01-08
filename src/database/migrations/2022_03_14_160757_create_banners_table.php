<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('link')->nullable();
            $table->text('attachment');
            $table->tinyInteger('type_show')->comment('1: random/ランダム, 2: default/ディフォルト');
            $table->tinyInteger('type')->comment('1: main visual, 2: banner');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
