<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert(
            [
                ["role_name" => "admin", "display_name" => "Quản lý hệ thống"],
                ["role_name" => "developer", "display_name" => "Phát triển hệ thống"],
                ["role_name" => "guest", "display_name" => "Khách hàng"],
                ["role_name" => "content", "display_name" => "Chỉnh sửa nội dung"]
            ]
        );
    }
}
