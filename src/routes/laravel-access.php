<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'namespace'  => 'Starmoozie\LaravelAccess\app\Http\Controllers',
    'prefix'     => config('laravel-access.route_prefix')
], function () {
    Route::group([
        'namespace' => 'Auth'
    ], function () {
        $login    = config('laravel-access.auth_route.login');
        $register = config('laravel-access.auth_route.register');

        Route::post($login, "LoginController@login")->name($login);

        if (config('laravel-access.register')) {
            Route::post($register, "RegisterController@register")->name($register);
        }
    });

    if (Schema::hasTable('users')) {
        Route::group([
            'middleware' => ['api', 'auth:api']
        ], function () {

            Route::get('profile', 'ProfileController@show')->name('profile');
            $user = \Auth::user();

            // Route based on user -> role -> menu -> permissions
            if ($user) {
                foreach ($user->menu as $menu) {
                    $page     = ucwords($menu->name);
                    $endpoint = $menu->key === "show"
                        ? strtolower($menu->name) . "/{id}"
                        : strtolower($menu->name);

                    Route::{$menu->method}($endpoint, "{$page}Controller@{$menu->key}")
                        ->name("{$menu->name}.{$menu->key}");
                }
            }
        });
    }
});
