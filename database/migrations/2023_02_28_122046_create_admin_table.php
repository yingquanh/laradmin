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
        Schema::create('tb_admin', function (Blueprint $table) {
            $table->id();
            $table->string('account', 200)->nullable(false)->default('')->comment('账号');
            $table->string('name', 100)->nullable(false)->default('')->comment('姓名');
            $table->string('avatar', 255)->nullable(false)->default('')->comment('头像');
            $table->string('email', 255)->nullable(false)->default('')->comment('电子邮箱');
            $table->char('mobile', 11)->nullable(false)->default('')->comment('手机号码');
            $table->string('password', 255)->nullable(false)->default('')->comment('账号密码');
            $table->tinyInteger('status')->nullable(false)->default(0)->comment('状态: -1 - 异常; 0 - 正常; 1 - 禁用');
            $table->rememberToken()->default('')->comment('记住密钥');
            $table->dateTime('created_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->dateTime('updated_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('更新时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
            $table->unique('account', 'uni_account_uuid');
            $table->index('name', 'idx_account_name');
            $table->index('email', 'idx_account_email');
            $table->index('mobile', 'idx_account_mobile');
        });

        DB::statement("ALTER TABLE `tb_admin` COMMENT '管理员表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_admin');
    }
};
