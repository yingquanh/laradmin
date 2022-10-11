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
        Schema::create('t_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable(false)->default(0)->comment('父级权限ID');
            $table->string('title', 100)->nullable(false)->default('')->comment('权限名称');
            $table->string('node', 100)->nullable(false)->default('')->comment('权限节点');
            $table->string('route', 100)->nullable(false)->default('')->comment('权限路由');
            $table->string('component', 100)->nullable(false)->default('')->comment('权限组件');
            $table->string('icon', 100)->nullable(false)->default('')->comment('菜单图标');
            $table->unsignedTinyInteger('is_menu')->nullable(false)->default(0)->comment('导航菜单: 0 - 否; 1 - 是');
            $table->unsignedInteger('sort')->nullable(false)->default(0)->comment('排序值，值越大权重越高');
            $table->dateTime('created_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->dateTime('updated_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('更新时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
        });

        DB::statement("ALTER TABLE `t_permission` COMMENT '系统权限表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_permission');
    }
};
