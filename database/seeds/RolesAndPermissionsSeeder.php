<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\15 0015
 * Time: 17:25
 */

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {

        // 重置角色和权限的缓存
        app()['cache']->forget('spatie.permission.cache');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Role::truncate();
        \DB::table('model_has_permissions')->truncate();
        \DB::table('role_has_permissions')->truncate();
        Permission::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');


        // 创建权限
        Permission::create(['name' => 'article-index', 'chinese_name' => '文章列表']);
        Permission::create(['name' => 'article-sort', 'chinese_name' => '文章排序']);
        Permission::create(['name' => 'article-create', 'chinese_name' => '创建文章']);
        Permission::create(['name' => 'article-store', 'chinese_name' => '发布文章']);
        Permission::create(['name' => 'article-destroy', 'chinese_name' => '假·删除文章']);
        Permission::create(['name' => 'article-ForceDelete', 'chinese_name' => '真·删除文章']);
        Permission::create(['name' => 'article-edit', 'chinese_name' => '修改文章']);
        Permission::create(['name' => 'article-update', 'chinese_name' => '编辑文章']);



        // 创建角色并赋予已创建的权限
        $role = Role::create(['name' => 'super-admin', 'chinese_name' => '超级管理员']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'editor', 'chinese_name' => '编辑']);
        $role->givePermissionTo([
            'article-index',
            'article-sort',
            'article-create',
            'article-store',
            'article-edit',
            'article-update',
        ]);



    }
}