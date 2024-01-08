<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageThumbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_thumbs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id');
            $table->text('image');
            $table->tinyInteger('type')->comment('Type of image, example: 1 - user, 2 - product,..');
            $table->tinyInteger('is_avatar')->comment('0-Not avatar; 1-Is avatar')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_thumbs');
    }
}
