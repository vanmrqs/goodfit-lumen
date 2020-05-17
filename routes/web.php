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

$router->group(['prefix' => 'candidatura'], function () use ($router) {
    $router->get('/', 'CandidaturaController@index');
    $router->get('/{codCandidatura}', 'CandidaturaController@show');
    $router->post('/', 'CandidaturaController@store');
    $router->delete('/{codCandidatura}', 'CandidaturaController@destroy');
    $router->put('{codCandidatura}/status/', 'CandidaturaController@trocarStatus');
});

$router->group(['prefix' => 'categoria'], function () use ($router) {
    $router->get('/', 'CategoriaController@index');
    $router->get('/{codCategoria}', 'CategoriaController@show');
    $router->post('/', 'CategoriaController@store');
    $router->put('/{codCategoria}', 'CategoriaController@update');
    $router->delete('/{codCategoria}', 'CategoriaController@destroy');
});

$router->group(['prefix' => 'curriculo'], function () use ($router) {
    $router->get('/', 'CurriculoController@index');
    $router->get('/{codCurriculo}', 'CurriculoController@show');
    $router->post('/', 'CurriculoController@store');
    $router->put('/{codCurriculo}', 'CurriculoController@update');
    $router->delete('/{codCurriculo}', 'CurriculoController@destroy');

    $router->get('/adicional/{codAdicionalCurriculo}', 'AdicionalCurriculoController@show');
    $router->post('/adicional', 'AdicionalCurriculoController@store');
    $router->delete('/adicional/{codAdicionalCurriculo}', 'AdicionalCurriculoController@destroy');
    $router->get('/{codCurriculo}/adicional', 'AdicionalController@getEmCurriculo');

    $router->get('{codCurriculo}/cargo', 'CategoriaController@getPorCurriculo');

    $router->get('/cargo/{codCargoCurriculo}', 'CargoCurriculoController@show');
    $router->post('/cargo', 'CargoCurriculoController@store');
    $router->delete('/cargo/{codCargoCurriculo}', 'CargoCurriculoController@destroy');
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
