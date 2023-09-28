<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SimplePermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SimplePermissionPermissionSeeder::class,
            SimplePermissionRoleSeeder::class,
        ]);
    }
}

