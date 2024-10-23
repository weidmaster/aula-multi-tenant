<?php

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

Route::get('/', function () {
    return view('welcome');
});

$appUrl = config('app.url');
$domain = parse_url($appUrl)['host'];
$tenantParam = config('tenant.route_param');
dump($domain, $tenantParam);
Route::domain("{{$tenantParam}}.{$domain}")
        ->middleware('tenant')
        ->group(function () {
            Auth::routes();
            Route::get('test', function () {
                return 'Hello World!';
            });
            Route::prefix('/admin')
            ->middleware('auth:web')
            ->group(function () {
                Route::get('/', function () {
                    return 'Admin';
                });
            });
            Route::prefix('/app')
            ->middleware('auth:web_tenants')
            ->group(function () {
                Route::resource('categories', 'CategoriesController');
                Route::get('/', function () {
                    return 'App Multi Tenancy';
                });
            });
            Route::get('/home', 'HomeController@index')->name('home');
        });
