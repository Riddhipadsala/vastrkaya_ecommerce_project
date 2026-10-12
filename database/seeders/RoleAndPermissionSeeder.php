<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();
       
            $permission = [
                'view-dashboard',
                'view-reports',
                'export-reports',
            
                'view-categories',
                'create-categories',
                'edit-categories',
                'delete-categories',

                'view-products',
                'create-products',
                'edit-products',
                'delete-products',
                'manage-inventory',

                'view-orders',
                'update-order-status',
                'cancel-orders',
                'process-refunds',
                'print-invoices',
            
                'view-customers',
                'edit-customers',
                'block-customers',
                'delete-customers',

                'view-coupons',
                'create-coupons',
                'edit-coupons',
                'delete-coupons',

                'view-reviews',
                'approve-reviews',
                'delete-reviews',

                'manage-banners',
                'manage-pages',

                'view-roles',
                'create-roles',
                'edit-roles',
                'delete-roles',

                'manage-settings',
        ];

        foreach($permission as $p){
            Permission::firstOrCreate ([
                'name' => $p,
                'guard_name' => 'web'
            ]);
        }
        
        $adminRole = Role::findOrCreate('admin', 'web');
        $customerRole = Role::findOrCreate('customer', 'web');
        
        $adminRole->syncPermissions($permission);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole($adminRole);

        // Clear permission cache again
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();
    }
}
