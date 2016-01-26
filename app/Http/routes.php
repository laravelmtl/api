<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Dingo Api has it's own router, so make sure you use it...
|
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => ['api.throttle', 'api.auth'], 'limit' => 10, 'expires' => 5], function ($api) {
    $api->resource('users', 'App\Http\Controllers\Api\V1\UserController');
});

$api->version('v2', ['middleware' => 'api.auth'], function ($api) {
    $api->resource('users', 'App\Http\Controllers\Api\V2\UserController');
});


/*
|--------------------------------------------------------------------------
| JWT Routes
|--------------------------------------------------------------------------
|
| Generates and validates tokens for api use
|
*/

Route::post('login', [
    'prefix'    => "api",
    'uses'      => 'AuthenticateController@authenticate',
]);

Route::get('refresh', [
    'prefix'    => "api",
    'middleware'=> ["jwt.auth", "jwt.refresh"],
    'uses'      => 'AuthenticateController@validateToken',
]);