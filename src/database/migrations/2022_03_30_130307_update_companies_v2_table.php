<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCompaniesV2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropUnique('companies_email_unique');
            $table->unique(['email', 'deleted_at']);
            $table->unique(['phone', 'deleted_at']);
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
            $table->dropUnique('companies_email_deleted_at_unique');
            $table->dropUnique('companies_phone_deleted_at_unique');
        });
    }
}
