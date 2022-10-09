<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
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
        Schema::create('t_account', function (Blueprint $table) {
            $table->id();
            $table->string('account_name', 200)->nullable(false)->default('')->comment('账号名称');
            $table->string('account_password', 255)->nullable(false)->default('')->comment('账号密码');
            $table->string('email', 255)->nullable(false)->default('')->comment('电子邮箱');
            $table->char('mobile', 11)->nullable(false)->default('')->comment('手机号码');
            $table->tinyInteger('status')->nullable(false)->default(0)->comment('状态: -1 - 异常; 0 - 正常; 1 - 禁用');
            $table->dateTime('created_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->dateTime('updated_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('更新时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
            $table->index('account_name', 'idx_account_name');
            $table->index('email', 'idx_account_email');
            $table->index('mobile', 'idx_account_mobile');
        });

        DB::statement("ALTER TABLE `t_account` COMMENT '系统账号表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_account');
    }
};
