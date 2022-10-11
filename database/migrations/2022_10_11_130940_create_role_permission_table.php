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
        Schema::create('t_role_permission', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable(false)->default(0)->comment('角色ID');
            $table->unsignedBigInteger('permission_id')->nullable(false)->default(0)->comment('权限ID');
            $table->unique(['role_id', 'permission_id'], 'uni_role_permission');
        });

        DB::statement("ALTER TABLE `t_role_permission` COMMENT '系统角色权限表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_role_permission');
    }
};
