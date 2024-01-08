<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRejectReasonToGachasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gachas', function (Blueprint $table) {
            $table->text('reject_reason')->nullable()->comment('Reject reason of gacha');
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
            $table->dropColumn('reject_reason');
        });
    }
}
