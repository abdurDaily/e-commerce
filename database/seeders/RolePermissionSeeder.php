<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(
            ['name' => 'admin'],
        );

        $permission = [

            // User Management Permissions
            ['name' => 'user_create'],
            ['name' => 'user_edit'],
            ['name' => 'user_delete'],
            ['name' => 'user_view'],
            ['name' => 'user_roles_assign'],
            ['name' => 'user_roles_revoke'],
            
            // Product Management Permissions
            ['name' => 'products_create'],
            ['name' => 'products_edit'],
            ['name' => 'products_delete'],
            ['name' => 'products_view'], 
            // Manage product reviews
            
            // Category Management Permissions
            ['name' => 'categories_create'],
            ['name' => 'categories_edit'],
            ['name' => 'categories_delete'],
            ['name' => 'categories_view'],
            
            // Discount Management Permissions
            ['name' => 'discounts_create'],
            ['name' => 'discounts_edit'],
            ['name' => 'discounts_delete'],
            ['name' => 'discounts_view'],
            
           
            // Role Management Permissions
            ['name' => 'roles_create'],
            ['name' => 'roles_edit'],
            ['name' => 'roles_delete'],
            ['name' => 'roles_view'],
            
           
        ];

        foreach($permission as $item){
            Permission::create($item);
        }

        $role->syncPermissions(Permission::all());

        $users = User::whereIn('email', [
            'abdur@gmail.com',
            'test@gmail.com'
        ])->get();
        
        foreach ($users as $u) {
            $u->assignRole($role); 
        }
    }
}
