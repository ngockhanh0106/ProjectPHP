<?php

namespace Database\Seeders;

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
        DB::table('permissions')->insert([
            ['name' => 'product_view', 'display_name' => 'Xem danh sách sản phẩm', 'group_name' => 'Quản lý sản phẩm'],
            ['name' => 'product_store', 'display_name' => 'Tạo mới sản phẩm', 'group_name' => 'Quản lý sản phẩm'],
            ['name' => 'product_update', 'display_name' => 'Chỉnh sửa sản phẩm', 'group_name' => 'Quản lý sản phẩm'],
            ['name' => 'product_delete', 'display_name' => 'Xóa sản phẩm', 'group_name' => 'Quản lý sản phẩm'],

            ['name' => 'category_view', 'display_name' => 'Xem danh sách danh mục sản phẩm', 'group_name' => 'Quản lý danh mục sản phẩm'],
            ['name' => 'category_store', 'display_name' => 'Tạo mới danh mục sản phẩm', 'group_name' => 'Quản lý danh mục sản phẩm'],
            ['name' => 'category_update', 'display_name' => 'Chỉnh sửa danh mục sản phẩm', 'group_name' => 'Quản lý danh mục sản phẩm'],
            ['name' => 'category_delete', 'display_name' => 'Xóa danh mục sản phẩm', 'group_name' => 'Quản lý danh mục sản phẩm'],

            ['name' => 'blog_view', 'display_name' => 'Xem danh sách blog', 'group_name' => 'Quản lý blog'],
            ['name' => 'blog_store', 'display_name' => 'Tạo mới blog', 'group_name' => 'Quản lý blog'],
            ['name' => 'blog_update', 'display_name' => 'Chỉnh sửa blog', 'group_name' => 'Quản lý blog'],
            ['name' => 'blog_delete', 'display_name' => 'Xóa blog', 'group_name' => 'Quản lý blog'],

            ['name' => 'staff_view', 'display_name' => 'Xem danh sách nhân viên', 'group_name' => 'Quản lý nhân viên'],
            ['name' => 'staff_store', 'display_name' => 'Thêm mới nhân viên', 'group_name' => 'Quản lý nhân viên'],
            ['name' => 'staff_update', 'display_name' => 'Chỉnh sửa thông tin nhân viên', 'group_name' => 'Quản lý nhân viên'],
            ['name' => 'staff_delete', 'display_name' => 'Xóa nhân viên', 'group_name' => 'Quản lý nhân viên'],

            ['name' => 'role_view', 'display_name' => 'Xem danh sách role', 'group_name' => 'Quản lý role'],
            ['name' => 'role_store', 'display_name' => 'Thêm mới role', 'group_name' => 'Quản lý role'],
            ['name' => 'role_update', 'display_name' => 'Chỉnh sửa role', 'group_name' => 'Quản lý role'],
            ['name' => 'role_delete', 'display_name' => 'Xóa role', 'group_name' => 'Quản lý role']
        ]);
    }
}
