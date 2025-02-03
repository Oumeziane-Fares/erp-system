<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define user-role mappings
        $userRoles = [
            [
                'user_id' => 1, // Assign 'admin' role to user_id 1
                'role_id' => DB::table('roles')->where('role_name', 'admin')->first()->role_id,
            ],
            [
                'user_id' => 2, // Assign 'manager' role to user_id 2
                'role_id' => DB::table('roles')->where('role_name', 'manager')->first()->role_id,
            ],
            [
                'user_id' => 3, // Assign 'viewer' role to user_id 3
                'role_id' => DB::table('roles')->where('role_name', 'viewer')->first()->role_id,
            ],
        ];

        // Insert into user_roles table
        DB::table('user_roles')->insert($userRoles);
    }
}
