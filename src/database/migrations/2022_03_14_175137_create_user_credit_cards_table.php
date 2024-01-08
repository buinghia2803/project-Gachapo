<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCreditCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_credit_cards', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('card_number', 50);
            $table->string('security_code', 50);
            $table->string('card_name');
            $table->string('date_of_expiry', 50);
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
        Schema::dropIfExists('user_credit_cards');
    }
}
