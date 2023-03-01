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
        Schema::create('tb_role_permission', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable(false)->default(0)->comment('角色ID');
            $table->unsignedBigInteger('permission_id')->nullable(false)->default(0)->comment('权限ID');
            $table->unique(['role_id', 'permission_id'], 'uni_role_relat_permission');
        });

        DB::statement("ALTER TABLE `tb_role_permission` COMMENT '角色权限关系表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_role_permission');
    }
};
