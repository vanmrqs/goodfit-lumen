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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});

$router->group(['prefix' => 'adicional'], function () use ($router) {
    $router->get('/', 'AdicionalController@index');
    $router->get('/{codAdicional}', 'AdicionalController@show');
    $router->get('/tipo/{codTipoAdicional}', 'AdicionalController@getPorTipo');
    $router->get('/tipo/nome/{nomeTipoAdicional}', 'AdicionalController@getPorNomeTipo');
    $router->post('/', 'AdicionalController@store');
    $router->put('/{codAdicional}', 'AdicionalController@update');
    $router->delete('/{codAdicional}', 'AdicionalController@destroy');
});

$router->group(['prefix' => 'candidato'], function () use ($router) {
    $router->get('/', 'CandidatoController@index');
    $router->get('/{codCandidato}', 'CandidatoController@show');
    $router->get('/usuario/{codUsuario}', 'CandidatoController@getPorUsuario');
    $router->post('/', 'CandidatoController@store');
    $router->put('/{codCandidato}', 'CandidatoController@update');
    $router->delete('/{codCandidato}', 'CandidatoController@destroy');
});

$router->group(['prefix' => 'curriculo'], function () use ($router) {
    $router->get('/{codCurriculo}/adicional', 'AdicionalController@getEmCurriculo');
    $router->get('/adicional/{codAdicionalCurriculo}', 'AdicionalCurriculoController@show');
    $router->post('/adicional', 'AdicionalCurriculoController@store');
    $router->delete('/adicional/{codAdicionalCurriculo}', 'AdicionalCurriculoController@destroy');
});

$router->group(['prefix' => 'nivel-usuario'], function () use ($router) {
    $router->get('/', 'NivelUsuarioController@index');
    $router->get('/{codNivelUsuario}', 'NivelUsuarioController@show');
    $router->post('/', 'NivelUsuarioController@store');
    $router->put('/{codNivelUsuario}', 'NivelUsuarioController@update');
    $router->delete('/{codNivelUsuario}', 'NivelUsuarioController@destroy');
});

$router->group(['prefix' => 'vaga'], function () use ($router) {
    $router->get('/{codVaga}/beneficio', 'BeneficioController@getPorVaga');
    $router->get('/beneficio/{codBeneficio}', 'BeneficioController@show');
    $router->post('beneficio/', 'BeneficioController@store');
    $router->put('/beneficio/{codBeneficio}', 'BeneficioController@update');
    $router->delete('/beneficio/{codBeneficio}', 'BeneficioController@destroy');
});
