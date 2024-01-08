<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifies', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->text('attachment')->nullable();
            $table->tinyInteger('type')->comment('1: user/個人向け, 2: company/企業向け');
            $table->tinyInteger('status')->comment('1: publish/公開, 2: unpublish/非公開');
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
        Schema::dropIfExists('notifies');
    }
}
