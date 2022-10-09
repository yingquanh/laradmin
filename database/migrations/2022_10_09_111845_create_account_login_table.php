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
        Schema::create('t_account_login', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id')->nullable(false)->default(0)->comment('账号ID');
            $table->string('content', 255)->nullable(false)->default('')->comment('登录信息');
            $table->unsignedInteger('ipv4')->nullable(false)->default(0)->comment('IPv4地址');
            $table->string('address', 200)->nullable(false)->default('')->comment('登录地址');
            $table->string('device', 50)->nullable(false)->default('')->comment('登录设备');
            $table->string('platform', 50)->nullable(false)->default('')->comment('登录平台');
            $table->dateTime('created_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->dateTime('updated_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('更新时间');
            $table->index('account_id', 'idx_account_id');
        });

        DB::statement("ALTER TABLE `t_account_login` COMMENT '系统账号登录日志表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_account_login');
    }
};
