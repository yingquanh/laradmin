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
        Schema::create('tb_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable(false)->default(0)->comment('父级权限ID');
            $table->string('title', 100)->nullable(false)->default('')->comment('模块名称');
            $table->string('node', 100)->nullable(false)->default('')->comment('权限节点');
            $table->string('link', 100)->nullable(false)->default('')->comment('模块路由');
            $table->string('icon', 100)->nullable(false)->default('')->comment('菜单图标');
            $table->unsignedTinyInteger('menu')->nullable(false)->default(0)->comment('导航菜单: 0 - 否; 1 - 是');
            $table->unsignedTinyInteger('enabled')->nullable(false)->default(1)->comment('是否启用: 0 - 否; 1 - 是');
            $table->unsignedInteger('sort')->nullable(false)->default(0)->comment('排序值，值越大权重越高');
            $table->dateTime('created_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->dateTime('updated_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('更新时间');
        });

        DB::statement("ALTER TABLE `tb_permission` COMMENT '权限管理表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_permission');
    }
};
