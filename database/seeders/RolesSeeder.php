<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define roles
        $roles = [
            [
                'role_name' => 'admin',
                'description' => 'Administrator with full access',
                'created_by' => 1, // Assuming user_id 1 is the admin
            ],
            [
                'role_name' => 'manager',
                'description' => 'Manager with limited access',
                'created_by' => 1,
            ],
            [
                'role_name' => 'viewer',
                'description' => 'Viewer with read-only access',
                'created_by' => 1,
            ],
        ];

        // Insert roles into the database
        DB::table('roles')->insert($roles);
    }
}
