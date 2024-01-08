<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('gacha_id');
            $table->string('name');
            $table->integer('quantity');
            $table->text('attachment');
            $table->float('reward_percent');
            $table->string('reward_type', 100)->comment('A賞, B賞, C賞....');
            $table->tinyInteger('reward_status')->comment('1: Percentage management/割合管理, 2: Inventory control/在庫管理, 3: Do not discharge/排出しない');
            $table->tinyInteger('status')->comment('1: publish/公開, 2:draft/下書き');
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
        Schema::dropIfExists('products');
    }
}
