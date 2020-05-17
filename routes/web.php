<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/*
| In case you need to configure your .env file,
| uncomment the route method below and access 
| the created route to generate a random key
| you can use it to enable your .env file.
*/

// $router->get('/key', function() {
//     return \Illuminate\Support\Str::random(32);
// });



$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'nivel-usuario'], function () use ($router) {
    $router->get('/', 'NivelUsuarioController@index');
    $router->get('/{codNivelUsuario}', 'NivelUsuarioController@show');
    $router->post('/', 'NivelUsuarioController@store');
    $router->put('/{codNivelUsuario}', 'NivelUsuarioController@update');
    $router->delete('/{codNivelUsuario}', 'NivelUsuarioController@destroy');
});
