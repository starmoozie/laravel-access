<?php

namespace Starmoozie\LaravelAccess\database\seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Starmoozie\LaravelAccess\app\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('laravel-access.database.data.permissions') as $data) {
            $compare = $data;
            $data['id'] = \Str::uuid()->toString();

            Permission::updateOrCreate($compare, $data);
        }
    }
}
