<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject', 255);
            $table->longText('content');
            $table->text('attachment')->nullable();
            $table->string('cc', 255)->nullable();
            $table->string('bcc', 255)->nullable();
            $table->tinyInteger('type')->comment('1: Temporary registration/仮登録, 2: Completed registration/完了した会員登録, 3: reset password/パスワードの再設定, 4: booking/予約完了のお知らせ, 5: Temporary registration company/企業の仮登録, 6: reply review/返信レビュー, 7: approve company/会社を承認する, 8: Disapproved/会社を非承認する, 9: withdrawal acc/退会, 10: delivery/配送, 11: cancel booking/予約キャンセルのお知らせ');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_templates');
    }
}
