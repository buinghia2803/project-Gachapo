<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGachasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gachas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('category_id');
            $table->bigInteger('company_id');
            $table->float('selling_price'); //販売価格
            $table->float('discounted_price')->nullable(); //割引価格
            $table->float('discounted_percent')->nullable(); //割引率
            $table->float('postage');
            $table->tinyInteger('status_apply_discounts')->comment('1: apply/適用する, 2: not apply/適用しない');
            $table->boolean('status_operation')->comment('1: 稼働する, 0: 停止するき'); // 稼働設定 
            $table->tinyInteger('status')->comment('1: pending-wait for approve/保留中, 2: approved/承認, 3: disapproval/否認'); //  1: On sale/販売中, 2: suspended/停止中, 3: under application/申請中, 4: end of sale/販売終了'
            $table->timestamp('period_start');
            $table->timestamp('period_end');
            $table->text('description');
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
        Schema::dropIfExists('gachas');
    }
}
