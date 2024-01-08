<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCompaniesTableV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('status')
                ->default(0)
                ->comment('0:temporary account, 1: deactivate/ 無効, 2: active/有効, 3: blacklist/ブラックリスト, 4: withdrawal/退会')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('status')->default(1)
                ->comment('1: deactivate/ 非能動, 2: active/能動, 3: blacklist/ブラックリスト, 4: withdrawal/退会')
                ->change();
        });
    }
}
