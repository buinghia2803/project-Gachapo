<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCouponTableV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->timestamp('period_start')->nullable();
            $table->timestamp('period_end')->nullable();
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('period_start');
            $table->dropColumn('period_end');
            $table->tinyInteger('status')->comment('1: publish/公開, 2:unpublish/非公開');
        });
    }
}
