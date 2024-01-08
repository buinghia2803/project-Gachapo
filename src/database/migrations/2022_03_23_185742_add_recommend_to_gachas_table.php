<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecommendToGachasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gachas', function (Blueprint $table) {
            $table->tinyInteger('recommend')->default(0)->comment('0: false, 1; true');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gachas', function (Blueprint $table) {
            $table->dropColumn('recommend');
        });
    }
}
