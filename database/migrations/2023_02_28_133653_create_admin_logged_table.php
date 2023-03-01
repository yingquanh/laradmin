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
        Schema::create('tb_admin_logged', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable(false)->default(0)->comment('管理员ID');
            $table->unsignedInteger('ipv4')->nullable(false)->default(0)->comment('IPv4地址');
            $table->string('address', 100)->nullable(false)->default('')->comment('登录地址');
            $table->string('platform', 100)->nullable(false)->default('')->comment('登录平台');
            $table->dateTime('created_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->dateTime('updated_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('更新时间');
            $table->index('admin_id', 'idx_admin_id');
        });

        DB::statement("ALTER TABLE `tb_admin_logged` COMMENT '管理员登录记录'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_admin_logged');
    }
};
