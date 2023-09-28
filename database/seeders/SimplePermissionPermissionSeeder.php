<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Lcloss\SimplePermission\Models\Permission;
class SimplePermissionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objects = [
            'users',
            'permissions',
            'roles',
        ];

        $actions = [
            'access',
            'list',
            'create',
            'read',
            'update',
            'delete',
        ];

        foreach( $objects as $object ) {
            foreach( $actions as $action ) {
                Permission::insertOrIgnore([
                    'name'          => $object . '_' . $action,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }

        $others = [
            'app_access',
        ];

        foreach( $others as $permission ) {
            Permission::insertOrIgnore([
                'name'          => $permission,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
