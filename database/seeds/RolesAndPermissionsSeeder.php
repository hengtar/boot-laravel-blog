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
        Permission::create(['name' => 'boot', 'chinese_name' => '后台','p_id' => 0 ]);
        Permission::create(['name' => 'config', 'chinese_name' => '系统设置' ,'p_id' => 0]);
        Permission::create(['name' => 'article', 'chinese_name' => '文章管理' ,'p_id' => 0]);
        //设置
        Permission::create(['name' => 'config-seo', 'chinese_name' => 'SEO设置','p_id' => 2]);
        Permission::create(['name' => 'config-store', 'chinese_name' => '保存SEO','p_id' => 2]);
        Permission::create(['name' => 'config-admin', 'chinese_name' => '个人中心','p_id' => 2]);

        //词库
        Permission::create(['name' => 'keyword-index', 'chinese_name' => '词库列表','p_id' => 2]);
        Permission::create(['name' => 'keyword-sort', 'chinese_name' => '词库排序','p_id' => 2]);
        Permission::create(['name' => 'keyword-create', 'chinese_name' => '创建词库','p_id' => 2]);
        Permission::create(['name' => 'keyword-store', 'chinese_name' => '保存词库','p_id' => 2]);
        Permission::create(['name' => 'keyword-destroy', 'chinese_name' => '删除词库','p_id' => 2]);
        Permission::create(['name' => 'keyword-ForceDelete', 'chinese_name' => '真·删除词库','p_id' => 2]);
        Permission::create(['name' => 'keyword-restore', 'chinese_name' => '恢复词库','p_id' => 2]);
        Permission::create(['name' => 'keyword-edit', 'chinese_name' => '修改词库','p_id' => 2]);
        Permission::create(['name' => 'keyword-update', 'chinese_name' => '编辑词库','p_id' => 2]);

        //文章
        Permission::create(['name' => 'article-index', 'chinese_name' => '文章列表','p_id' => 3]);
        Permission::create(['name' => 'article-sort', 'chinese_name' => '文章排序','p_id' => 3]);
        Permission::create(['name' => 'article-create', 'chinese_name' => '创建文章','p_id' => 3]);
        Permission::create(['name' => 'article-store', 'chinese_name' => '发布文章','p_id' => 3]);
        Permission::create(['name' => 'article-destroy', 'chinese_name' => '删除文章','p_id' => 3]);
        Permission::create(['name' => 'article-restore', 'chinese_name' => '恢复文章','p_id' => 3]);
        Permission::create(['name' => 'article-ForceDelete', 'chinese_name' => '真·删除文章','p_id' => 3]);
        Permission::create(['name' => 'article-edit', 'chinese_name' => '修改文章','p_id' => 3]);
        Permission::create(['name' => 'article-update', 'chinese_name' => '编辑文章','p_id' => 3]);

        //文章分类
        Permission::create(['name' => 'category-index', 'chinese_name' => '分类列表','p_id' => 3]);
        Permission::create(['name' => 'category-sort', 'chinese_name' => '分类排序','p_id' => 3]);
        Permission::create(['name' => 'category-create', 'chinese_name' => '创建分类','p_id' => 3]);
        Permission::create(['name' => 'category-store', 'chinese_name' => '发布分类','p_id' => 3]);
        Permission::create(['name' => 'category-destroy', 'chinese_name' => '删除分类','p_id' => 3]);
        Permission::create(['name' => 'category-restore', 'chinese_name' => '恢复分类','p_id' => 3]);
        Permission::create(['name' => 'category-ForceDelete', 'chinese_name' => '真·删除分类','p_id' => 3]);
        Permission::create(['name' => 'category-edit', 'chinese_name' => '修改分类','p_id' => 3]);
        Permission::create(['name' => 'category-update', 'chinese_name' => '编辑分类','p_id' => 3]);





        // 创建角色并赋予已创建的权限
        $role =  Role::create(['name' => 'super-admin', 'chinese_name' => '超级管理员']);
        $role -> givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'editor', 'chinese_name' => '编辑']);
        $role->givePermissionTo([
            'article',

            'article-index',
            'article-sort',
            'article-create',
            'article-store',
            'article-edit',
            'article-update',

            'category-index',
            'category-sort',
            'category-create',
            'category-store',
            'category-edit',
            'category-update',

        ]);



    }
}