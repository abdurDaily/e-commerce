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
            ['name' => 'writer'],
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
            ['name' => 'products_import'],
            ['name' => 'products_export'],
        
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
        
            // Order Management Permissions
            ['name' => 'orders_create'],
            ['name' => 'orders_edit'],
            ['name' => 'orders_delete'],
            ['name' => 'orders_view'],
            ['name' => 'orders_process'],
            ['name' => 'orders_refund'],
        
            // Inventory Management Permissions
            ['name' => 'inventory_view'],
            ['name' => 'inventory_adjust'],
            ['name' => 'inventory_audit'],
        
            // Customer Management Permissions
            ['name' => 'customers_create'],
            ['name' => 'customers_edit'],
            ['name' => 'customers_delete'],
            ['name' => 'customers_view'],
            ['name' => 'customers_manage_inquiries'],
        
            // Reporting and Analytics Permissions
            ['name' => 'reports_view'],
            ['name' => 'analytics_access'],
            ['name' => 'sales_reports_view'],
            ['name' => 'customer_reports_view'],
        
            // Marketing Permissions
            ['name' => 'campaigns_create'],
            ['name' => 'campaigns_edit'],
            ['name' => 'campaigns_delete'],
            ['name' => 'campaigns_view'],
            ['name' => 'email_marketing_access'],
        
            // Site Settings Permissions
            ['name' => 'settings_edit'],
            ['name' => 'settings_view'],
        
            // Role Management Permissions
            ['name' => 'roles_create'],
            ['name' => 'roles_edit'],
            ['name' => 'roles_delete'],
            ['name' => 'roles_view'],
        
            // Miscellaneous Permissions
            ['name' => 'notifications_manage'],
            ['name' => 'api_access'],
            ['name' => 'data_backup'],
            ['name' => 'data_restore'],
        ];

        foreach($permission as $item){
            Permission::create($item);
        }

        $role->syncPermissions(Permission::all());

        $user = User::first();
        $user->assignRole($role);
    }
}
