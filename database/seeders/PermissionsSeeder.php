<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define permissions
        $permissions = [
            [
                'permission_name' => 'view-products',
                'description' => 'View products',
                'created_by' => 1, // Assuming user_id 1 is the admin
            ],
            [
                'permission_name' => 'create-products',
                'description' => 'Create products',
                'created_by' => 1,
            ],
            [
                'permission_name' => 'update-products',
                'description' => 'Update products',
                'created_by' => 1,
            ],
            [
                'permission_name' => 'delete-products',
                'description' => 'Delete products',
                'created_by' => 1,
            ],
            [
                'permission_name' => 'view-suppliers',
                'description' => 'View suppliers',
                'created_by' => 1,
            ],
            [
                'permission_name' => 'create-suppliers',
                'description' => 'Create suppliers',
                'created_by' => 1,
            ],
            [
                'permission_name' => 'update-suppliers',
                'description' => 'Update suppliers',
                'created_by' => 1,
            ],
            [
                'permission_name' => 'delete-suppliers',
                'description' => 'Delete suppliers',
                'created_by' => 1,
            ],
            [
                'permission_name' => 'add-stock',
                'description' => 'Add stock',
                'created_by' => 1,
            ],
            [
                'permission_name' => 'remove-stock',
                'description' => 'Remove stock',
                'created_by' => 1,
            ],
        ];

        // Insert permissions into the database
        DB::table('permissions')->insert($permissions);
    }
}
