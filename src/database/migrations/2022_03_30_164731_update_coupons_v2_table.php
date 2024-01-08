<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCouponsV2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->string('code', 50)->unique()->after('name');
            $table->tinyInteger('type_discount')->comment('1: 割合, 2: 金額')->after('price');
            $table->float('discount_rate')->nullable()->after('price');
            $table->float('discount_amount')->nullable()->after('price');
            $table->string('description', 2000)->nullable()->after('price');
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
            $table->float('price');
            $table->dropColumn('code');
            $table->dropColumn('type_discount');
            $table->dropColumn('discount_rate');
            $table->dropColumn('discount_amount');
            $table->dropColumn('description');
        });
    }
}
