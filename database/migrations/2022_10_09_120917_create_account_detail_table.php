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
        Schema::create('t_account_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id')->nullable(false)->default(0)->comment('账号ID');
            $table->string('name', 100)->nullable(false)->default('')->comment('姓名');
            $table->dateTime('created_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('创建时间');
            $table->dateTime('updated_at')->nullable(false)->default(new Expression('CURRENT_TIMESTAMP'))->comment('更新时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
            $table->index('account_id', 'idx_account_id');
        });

        DB::statement("ALTER TABLE `t_account_detail` COMMENT '系统账号信息表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_account_detail');
    }
};
