<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('name_furigana', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->integer('role_id')->default(1)->comment('1: Admin(管理者), 2: Sub admin(編集者)');
            $table->tinyInteger('status')->comment('1: deactivate: 非能動, 2: active/能動');
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
        Schema::dropIfExists('admins');
    }
}
