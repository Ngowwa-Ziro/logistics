<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
            // Clear cache to avoid stale permissions
            app()['cache']->forget('spatie.permission.cache');


            $roles = ['admin', 'driver', 'customer'];


            $permissions = [
                'manage users',
                'manage roles',
                'manage drivers',
                'manage assets',
                'book trip',
                'view trips',
                'approve trip',
                'cancel trip',
                'view customers',
            ];

            // Create roles if they don’t exist
            foreach ($roles as $role) {
                Role::firstOrCreate(['name' => $role]);
            }

            // Create permissions if they don’t exist
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }

            // Map permissions to roles
            $admin = Role::findByName('admin');
            $driver = Role::findByName('driver');
            $customer = Role::findByName('customer');


            $admin->syncPermissions($permissions);


            $driver->syncPermissions([
                'view trips',
                'approve trip',
                'cancel trip',
            ]);


            $customer->syncPermissions([
                'book trip',
                'view trips',
                'approve trip',
                'cancel trip',
            ]);

            $this->command->info('✅ Roles and Permissions seeded successfully!');

    }
}

