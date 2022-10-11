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
        Schema::create('t_account_role', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable(false)->default(0)->comment('账号ID');
            $table->unsignedBigInteger('role_id')->nullable(false)->default(0)->comment('角色ID');
            $table->unique(['account_id', 'role_id'], 'uni_account_role');
        });

        DB::statement("ALTER TABLE `t_account_role` COMMENT '系统用户组表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_account_role');
    }
};
