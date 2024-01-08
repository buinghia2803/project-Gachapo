<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('slug')->unique();
            $table->tinyInteger('status')->comment('1: publish/公開, 2: unpublish/非公開, 3:draft/下書き');
            $table->tinyInteger('type')->comment('1: プライバシーポリシー登録, 2: 特定商取引に関する表記登録, 3: 利用規約登録, 4: 資金決済法に関する表記登録, 5: コンプライアンスポリシー登録');
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
        Schema::dropIfExists('pages');
    }
}
