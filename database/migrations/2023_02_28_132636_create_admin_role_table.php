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
        Schema::create('tb_admin_role', function (Blueprint $table) {
            $table->bigInteger('admin_id')->nullable(false)->default(0)->comment('管理员ID');
            $table->bigInteger('role_id')->nullable(false)->default(0)->comment('角色ID');
            $table->unique(['admin_id', 'role_id'], 'uni_admin_relat_role');
        });

        DB::statement("ALTER TABLE `tb_admin_role` COMMENT '管理员角色关系表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_admin_role');
    }
};
