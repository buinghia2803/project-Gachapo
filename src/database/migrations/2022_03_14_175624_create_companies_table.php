<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company', 100)->nullable();
            $table->string('company_furigana', 100)->nullable();
            $table->string('person_manager', 100)->nullable();
            $table->string('person_manager_furigana', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->text('company_infomation')->nullable();
            $table->text('site_url')->nullable();
            $table->string('company_address')->nullable();
            $table->text('registered_copy_attachment')->nullable();
            $table->text('consent_document')->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('branch_name', 100)->nullable();
            $table->string('bank_code', 50)->nullable();
            $table->string('branch_code', 50)->nullable();
            $table->string('bank_type', 50)->nullable();
            $table->string('bank_number', 50)->nullable();
            $table->string('bank_holder', 100)->nullable();
            $table->float('commission')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('status_two_step_verification')->default(false);
            $table->boolean('status_notifice')->default(false);
            $table->tinyInteger('status')->default(1)->comment('1: deactivate/ 非能動, 2: active/能動, 3: blacklist/ブラックリスト, 4: withdrawal/退会');
            $table->tinyInteger('status_approve')->default(3)->comment('1: Waiting for approval/承認待ち, 2: Disapproved/非承認, 3: Approved/承認');
            $table->rememberToken();
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
        Schema::dropIfExists('companies');
    }
}
