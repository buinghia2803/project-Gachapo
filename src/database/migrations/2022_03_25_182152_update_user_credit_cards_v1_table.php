<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserCreditCardsV1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_credit_cards', function (Blueprint $table) {
            $table->string('stripe_card_id', 100)->after('card_name');
            $table->renameColumn('security_code', 'fingerprint');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_credit_cards', function (Blueprint $table) {
            $table->dropColumn('stripe_card_id');
            $table->renameColumn('fingerprint', 'security_code');
        });
    }
}
