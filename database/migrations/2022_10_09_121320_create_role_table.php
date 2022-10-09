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
        Schema::create('t_role', function (Blueprint $table) {
            $table->id();
            $table->string('role_name', 200)->nullable(false)->default('')->comment('角色名称');
            $table->dateTime('created_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->dateTime('updated_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('更新时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
        });

        DB::statement("ALTER TABLE `t_role` COMMENT '系统角色表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_role');
    }
};
