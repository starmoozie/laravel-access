<?php

namespace Starmoozie\LaravelAccess\database\seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Starmoozie\LaravelAccess\app\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::pluck('id')->toArray();
        $model = config('auth.providers.users.model');

        $user  = new $model;
        foreach (config('laravel-access.database.data.users') as $key => $data) {
            $compare = $data;
            $data['id']       = \Str::uuid()->toString();
            $data['password'] = \Hash::make($data['password']);
            $data['role_id']  = $roles[$key];

            $user->updateOrCreate($compare, $data);
        }
    }
}
