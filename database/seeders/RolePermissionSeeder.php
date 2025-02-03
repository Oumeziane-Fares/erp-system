<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Define role-permission mappings
        $rolePermissions = [
            'admin' => [
                'view-products',
                'create-products',
                'update-products',
                'delete-products',
                'view-suppliers',
                'create-suppliers',
                'update-suppliers',
                'delete-suppliers',
                'add-stock',
                'remove-stock',
            ],
            'manager' => [
                'view-products',
                'view-suppliers',
                'add-stock',
                'remove-stock',
            ],
            'viewer' => [
                'view-products',
                'view-suppliers',
            ],
        ];

        // Assign permissions to roles
        foreach ($rolePermissions as $roleName => $permissions) {
            // Get the role ID
            $role = DB::table('roles')->where('role_name', $roleName)->first();
            if (!$role) {
                continue;
            }

            // Get the permission IDs
            $permissionIds = DB::table('permissions')
                ->whereIn('permission_name', $permissions)
                ->pluck('permission_id')
                ->toArray();

            // Insert into role_permissions table
            foreach ($permissionIds as $permissionId) {
                DB::table('role_permissions')->insert([
                    'role_id' => $role->role_id,
                    'permission_id' => $permissionId,
                ]);
            }
        }
    }
    
}
