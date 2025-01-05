<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['permission_name' => 'create-post', 'description' => 'Create a new post']);
        Permission::create(['permission_name' => 'edit-post', 'description' => 'Edit existing posts']);
    }
}
