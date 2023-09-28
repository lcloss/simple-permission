<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Lcloss\SimplePermission\Models\Role;
use Lcloss\SimplePermission\Models\Permission;

class SimplePermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name'          => 'Super Admin',
                'slug'          => 'sysadmin',
                'level'         => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Admin',
                'slug'          => 'admin',
                'level'         => 5,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Premium User',
                'slug'          => 'premium-user',
                'level'         => 100,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'User',
                'slug'          => 'user',
                'level'         => 200,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Free Users',
                'slug'          => 'free-user',
                'level'         => 300,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];

        foreach( $roles as $roleData ) {
            Role::insertOrIgnore($roleData);

            $role = Role::where('slug', $roleData['slug'])->first();

            if ( $roleData['level'] == 1 ) {
                $role->permissions()->sync(Permission::select('id')->pluck('id'));
            }
        }
    }
}
