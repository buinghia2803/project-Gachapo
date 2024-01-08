<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name_furigana', 100)->nullable()->change();
            $table->bigInteger('customer_id')->nullable()->change();
            $table->string('birthday', 100)->nullable()->change();
            $table->string('phone', 20)->nullable()->change();
            $table->bigInteger('category_id')->nullable()->change();
            $table->string('address_first')->nullable()->change();
            $table->string('address_second')->nullable()->change();
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
            $table->string('name_furigana', 100)->nullable(false)->change();
            $table->bigInteger('customer_id')->nullable(false)->change();
            $table->string('birthday', 100)->nullable(false)->change();
            $table->string('phone', 20)->nullable(false)->change();
            $table->bigInteger('category_id')->nullable(false)->change();
            $table->string('address_first')->nullable(false)->change();
            $table->string('address_second')->nullable(false)->change();
        });
    }
}
