<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $permissions = [
            'manage users',
            'manage drivers',
            'manage assets',
            'book trip',
            'view trips',
            'approve trip',
            'cancel trip',
            'view customers',
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
            'assign permissions',
            'manage companies',
            'create corporate admin',
            'edit corporate admin',
            'delete corporate admin',

        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission], ['guard_name' => 'web']);
        }




    }
}

