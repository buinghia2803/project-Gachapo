<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersV1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name_furigana', 100);
            $table->string('customer_id', 100);
            $table->string('birthday', 100);
            $table->string('phone', 20);
            $table->bigInteger('category_id');
            $table->tinyInteger('gender')->nullable()->comment('1: Male(男性), 2: Female(女性), 3:other/その他');
            $table->string('profession')->nullable();
            $table->string('address_first');
            $table->string('address_second');
            $table->tinyInteger('address_type')->default(1)->comment('Main address of delivery/配達の主な住所, 1: address_first, 2: address_second');
            $table->tinyInteger('status')->default(1)->comment('1: deactivate: 非能動, 2: active/能動, 3: blacklist/ブラックリスト, 4: withdrawal/退会');
            $table->boolean('status_two_step_verification')->default(false);
            $table->boolean('status_notifice')->default(true);
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name_furigana');
            $table->dropColumn('customer_id');
            $table->dropColumn('birthday');
            $table->dropColumn('phone');
            $table->dropColumn('category_id');
            $table->dropColumn('gender');
            $table->dropColumn('profession');
            $table->dropColumn('address_first');
            $table->dropColumn('address_second');
            $table->dropColumn('address_type');
            $table->dropColumn('status');
            $table->dropColumn('status_two_step_verification');
            $table->dropColumn('status_notifice');
            $table->dropColumn('deleted_at');
        });
    }
}
