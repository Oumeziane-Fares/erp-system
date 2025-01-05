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
        // Create roles
        $adminRole = Role::create(['role_name' => 'admin', 'description' => 'Administrator']);
        $managerRole = Role::create(['role_name' => 'manager', 'description' => 'Manager']);
        $userRole = Role::create(['role_name' => 'user', 'description' => 'Standard User']);

        // Create permissions
        $createUser = Permission::create(['permission_name' => 'create-user', 'description' => 'Create new users']);
        $deleteUser = Permission::create(['permission_name' => 'delete-user', 'description' => 'Delete users']);

        // Assign permissions to roles
        $adminRole->permissions()->attach([$createUser->permission_id, $deleteUser->permission_id]);
        $managerRole->permissions()->attach([$createUser->permission_id]);
    }
    
}
