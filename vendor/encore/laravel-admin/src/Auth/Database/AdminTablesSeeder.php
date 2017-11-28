<?php

namespace Encore\Admin\Auth\Database;

use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create a user.
        Administrator::truncate();
        Administrator::create([
            'username'  => 'admin',
            'password'  => bcrypt('admin'),
            'name'      => '系统管理员',
        ]);

        // create a role.
        Role::truncate();
        Role::create([
            'name'  => '系统管理员',
            'slug'  => '系统管理员',
        ]);

        // add role to user.
        Administrator::first()->roles()->save(Role::first());

        //create a permission
        Permission::truncate();
        Permission::insert([
            [
                'name'        => 'All permission',
                'slug'        => '*',
                'http_method' => '',
                'http_path'   => '*',
            ],
            [
                'name'        => 'Dashboard',
                'slug'        => 'dashboard',
                'http_method' => 'GET',
                'http_path'   => '/',
            ],
            [
                'name'        => 'Login',
                'slug'        => 'auth.login',
                'http_method' => '',
                'http_path'   => "/auth/login\r\n/auth/logout",
            ],
            [
                'name'        => 'User setting',
                'slug'        => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path'   => '/auth/setting',
            ],
            [
                'name'        => 'Auth management',
                'slug'        => 'auth.management',
                'http_method' => '',
                'http_path'   => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs",
            ],
        ]);

        Role::first()->permissions()->save(Permission::first());

        // add default menus.
        Menu::truncate();
        Menu::insert([
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => '首页',
                'icon'      => 'fa-home',
                'uri'       => '/',
            ],
            [
                'parent_id' => 0,
                'order'     => 2,
                'title'     => '权限管理',
                'icon'      => 'fa-lock',
                'uri'       => '',
            ],
            [
                'parent_id' => 0,
                'order'     => 3,
                'title'     => '账户管理',
                'icon'      => 'fa-user',
                'uri'       => 'auth/users',
            ],
            [
                'parent_id' => 0,
                'order'     => 4,
                'title'     => '模板管理',
                'icon'      => 'fa-file-text',
                'uri'       => 'auth/roles',
            ],
            [
                'parent_id' => 0,
                'order'     => 5,
                'title'     => '财务管理',
                'icon'      => 'fa-list-alt',
                'uri'       => 'auth/permissions',
            ],
            [
                'parent_id' => 0,
                'order'     => 6,
                'title'     => '系统管理',
                'icon'      => 'fa-gears',
                'uri'       => 'auth/menu',
            ],
            [
                'parent_id' => 0,
                'order'     => 7,
                'title'     => 'Operation log',
                'icon'      => 'fa-history',
                'uri'       => 'auth/logs',
            ],
        ]);

        // add role to menu.
        Menu::find(2)->roles()->save(Role::first());
    }
}
