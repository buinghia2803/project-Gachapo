<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('gacha_id');
            $table->bigInteger('user_id');
            $table->bigInteger('coupon_id');
            $table->float('coupon_price');
            $table->integer('quantity');
            $table->float('gacha_price');
            $table->string('address_delivery');
            $table->tinyInteger('status_deliver')->comment('1: Not delivery/未発送、2: in delivery/配送中, 3: delivered/ 発送、4: canceled/キャンセル');
            $table->timestamp('date_of_shipment');
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
        Schema::dropIfExists('orders');
    }
}
