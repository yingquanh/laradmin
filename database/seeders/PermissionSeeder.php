<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_permission')->insert([
            ['id' => 1, 'parent_id' => 0, 'title' => '系统管理', 'node' => 'admin:system', 'link' => 'Settings', 'icon' => 'SettingOutlined', 'menu' => 1, 'sort' => 0],
            ['id' => 2, 'parent_id' => 1, 'title' => '角色管理', 'node' => 'admin:role', 'link' => 'Role', 'icon' => '', 'menu' => 1, 'sort' => 999],
            ['id' => 3, 'parent_id' => 2, 'title' => '新增角色', 'node' => 'admin:role:create', 'link' => '', 'icon' => '', 'menu' => 0, 'sort' => 999],
            ['id' => 4, 'parent_id' => 2, 'title' => '编辑角色', 'node' => 'admin:role:edit', 'link' => '', 'icon' => '', 'menu' => 0, 'sort' => 99],
            ['id' => 5, 'parent_id' => 2, 'title' => '删除角色', 'node' => 'admin:role:delete', 'link' => '', 'icon' => '', 'menu' => 0, 'sort' => 9],
            ['id' => 6, 'parent_id' => 1, 'title' => '账号管理', 'node' => 'admin:account', 'link' => 'Account', 'icon' => '', 'menu' => 1, 'sort' => 9999],
            ['id' => 7, 'parent_id' => 6, 'title' => '新增账号', 'node' => 'admin:account:create', 'link' => '', 'icon' => '', 'menu' => 0, 'sort' => 999],
            ['id' => 8, 'parent_id' => 6, 'title' => '编辑账号', 'node' => 'admin:account:edit', 'link' => '', 'icon' => '', 'menu' => 0, 'sort' => 99],
            ['id' => 9, 'parent_id' => 6, 'title' => '删除账号', 'node' => 'admin:account:delete', 'link' => '', 'icon' => '', 'menu' => 0, 'sort' => 9],
        ]);
    }
}
