<?php

namespace Starmoozie\LaravelAccess\database\seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Starmoozie\LaravelAccess\app\Models\{
    Menu,
    Permission
};
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MenuPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::pluck('id')->toArray();

        foreach (Menu::select(['id'])->get() as $menu) {
            $menu->permissions()->sync($permissions);
        }
    }
}
