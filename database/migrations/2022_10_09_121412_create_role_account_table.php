<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_role_account', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable(false)->default(0)->comment('角色ID');
            $table->unsignedBigInteger('account_id')->nullable(false)->default(0)->comment('账号ID');
            $table->unique(['role_id', 'account_id'], 'uni_role_account');
        });

        DB::statement("ALTER TABLE `t_role_account` COMMENT '系统角色组表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_role_account');
    }
};
