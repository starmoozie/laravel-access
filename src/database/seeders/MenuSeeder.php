<?php

namespace Starmoozie\LaravelAccess\database\seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Starmoozie\LaravelAccess\app\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('laravel-access.database.data.menus') as $data) {
            $compare = $data;
            $data['id'] = \Str::uuid()->toString();

            Menu::updateOrCreate($compare, $data);
        }
    }
}
