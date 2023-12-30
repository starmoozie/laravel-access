<?php

namespace Starmoozie\LaravelAccess\database\seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Starmoozie\LaravelAccess\app\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('laravel-access.database.data.roles') as $data) {
            $compare = $data;
            $data['id'] = \Str::uuid()->toString();

            Role::updateOrCreate($compare, $data);
        }
    }
}
