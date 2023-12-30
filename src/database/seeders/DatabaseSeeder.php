<?php

namespace Starmoozie\LaravelAccess\database\seeders;

use Illuminate\Database\Seeder;
use Starmoozie\LaravelAccess\app\Models\MenuPermission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            MenuSeeder::class,
            RoleSeeder::class,
            MenuPermissionSeeder::class,
            MenuPermissionRoleSeeder::class,
            UserSeeder::class
        ]);
    }
}
