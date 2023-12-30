<?php

namespace Starmoozie\LaravelAccess\database\seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Starmoozie\LaravelAccess\app\Models\{
    Role,
    MenuPermission
};
use Illuminate\Database\Seeder;

class MenuPermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = MenuPermission::pluck('id')->toArray();

        foreach (Role::select(['id'])->get() as $key => $role) {
            $role->menuPermissions()->sync($permissions);
        }
    }
}
