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

$router->group(['middleware' => 'jwt.auth'],
    function() use ($router) {
        $router->group(['prefix' => 'empresa'], function () use ($router) {
            $router->get('/candidatos', 'CandidatoController@getCandidatosPorEmpresa');
            $router->get('/vagas', 'VagaController@getPorEmpresa');
            $router->get('/vagas/processo', 'CandidatoController@getEmProcessoPorEmpresa');
        });

        $router->group(['prefix' => 'experiencia-profissional'], function () use ($router) {
            $router->get('/{codCurriculo}', 'ExperienciaProfissional@getPorCurriculo');
        });

        $router->group(['prefix' => 'candidato'], function () use ($router) {
            $router->get('/{codCandidato}', 'CandidatoController@getCandidato');
        });

        $router->group(['prefix' => 'candidatura'], function () use ($router) {
            $router->put('{codCandidatura}/status/', 'CandidaturaController@trocarStatus');
        });

        $router->group(['prefix' => 'vaga'], function () use ($router) {
            $router->get('/{codVaga}', 'VagaController@getVaga');

            $router->get('/{codVaga}/beneficio', 'BeneficioController@getPorVaga');

            $router->get('/requisito/{codVaga}', 'AdicionalController@getEmVaga');
        });
    }
);

$router->post('/login', 'UsuarioController@login');

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
    $router->get('/usuario/{codUsuario}', 'CandidatoController@getPorUsuario');
    $router->post('/', 'CandidatoController@store');
    $router->put('/{codCandidato}', 'CandidatoController@update');
    $router->delete('/{codCandidato}', 'CandidatoController@destroy');
});

$router->group(['prefix' => 'candidatura'], function () use ($router) {
    $router->get('/', 'CandidaturaController@index');
    $router->get('/{codCandidatura}', 'CandidaturaController@show');
    $router->get('/{codCandidatura}/status', 'StatusController@getPorCandidatura');
    $router->post('/', 'CandidaturaController@store');
    $router->delete('/{codCandidatura}', 'CandidaturaController@destroy');
});

$router->group(['prefix' => 'categoria'], function () use ($router) {
    $router->get('/', 'CategoriaController@index');
    $router->get('/{codCategoria}', 'CategoriaController@show');
    $router->get('/{codCategoria}/profissao', 'ProfissaoController@getPorCategoria');
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
    $router->get('/candidato/{codCandidato}', 'CurriculoController@getCurriculoByCandidatoId');

    $router->get('/adicional/{codAdicionalCurriculo}', 'AdicionalCurriculoController@show');
    $router->post('/adicional', 'AdicionalCurriculoController@store');
    $router->post('/adicionais', 'AdicionalCurriculoController@criaAdicionais');
    $router->put('{codCurriculo}/adicionais/', 'AdicionalCurriculoController@editaAdicionais');
    $router->delete('/adicional/{codAdicionalCurriculo}', 'AdicionalCurriculoController@destroy');
    $router->get('/{codCurriculo}/adicional', 'AdicionalController@getEmCurriculo');

    $router->get('{codCurriculo}/cargo', 'CategoriaController@getPorCurriculo');
    $router->get('/cargo/{codCargoCurriculo}', 'CargoCurriculoController@show');
    $router->post('/cargo', 'CargoCurriculoController@store');
    $router->post('/cargos', 'CargoCurriculoController@adicionaCargos');
    $router->put('{codCurriculo}/cargos/', 'CargoCurriculoController@editaCargos');
    $router->delete('/cargo/{codCargoCurriculo}', 'CargoCurriculoController@destroy');
});

$router->group(['prefix' => 'empresa'], function () use ($router) {
    $router->get('/', 'EmpresaController@index');
    $router->get('/{codEmpresa}', 'EmpresaController@show');
    $router->post('/', 'EmpresaController@store');
    $router->put('/{codEmpresa}', 'EmpresaController@update');
    $router->delete('/{codEmpresa}', 'EmpresaController@destroy');
});

$router->group(['prefix' => 'endereco'], function () use ($router) {
    $router->get('/{codEndereco}', 'EnderecoController@show');
    $router->post('/', 'EnderecoController@getPorArray');
    $router->post('/store', 'EnderecoController@store');
});

$router->group(['prefix' => 'experiencia-profissional'], function () use ($router) {
    $router->post('/', 'ExperienciaProfissional@store');
    $router->put('/{codExperiencia}', 'ExperienciaProfissional@update');
});

$router->group(['prefix' => 'habilidade'], function () use ($router) {
    $router->get('/{codCurriculo}', 'AdicionalController@getHabilidadesCurriculo');
});

$router->group(['prefix' => 'nivel-usuario'], function () use ($router) {
    $router->get('/', 'NivelUsuarioController@index');
    $router->get('/{codNivelUsuario}', 'NivelUsuarioController@show');
    $router->post('/', 'NivelUsuarioController@store');
    $router->put('/{codNivelUsuario}', 'NivelUsuarioController@update');
    $router->delete('/{codNivelUsuario}', 'NivelUsuarioController@destroy');
});

$router->group(['prefix' => 'profissao'], function () use ($router) {
    $router->get('/', 'ProfissaoController@index');
    $router->get('/{codProfissao}', 'ProfissaoController@show');
    $router->post('/', 'ProfissaoController@store');
    $router->put('/{codProfissao}', 'ProfissaoController@update');
    $router->delete('/{codProfissao}', 'ProfissaoController@destroy');
});

$router->group(['prefix' => 'regime-contratacao'], function () use ($router) {
    $router->get('/', 'RegimeContratacaoController@index');
    $router->get('/{codRegimeContratacao}', 'RegimeContratacaoController@show');
    $router->post('/', 'RegimeContratacaoController@store');
    $router->put('/{codRegimeContratacao}', 'RegimeContratacaoController@update');
    $router->delete('/{codRegimeContratacao}', 'RegimeContratacaoController@destroy');
});

$router->group(['prefix' => 'status'], function () use ($router) {
    $router->get('/', 'StatusController@index');
    $router->get('/{codStatus}', 'StatusController@show');
    $router->post('/', 'StatusController@store');
    $router->put('/{codStatus}', 'StatusController@update');
});

$router->group(['prefix' => 'tipo-adicional'], function () use ($router) {
    $router->get('/', 'TipoAdicionalController@index');
    $router->get('/{codTipoAdicional}', 'TipoAdicionalController@show');
    $router->get('/nome/{nomeTipo}', 'TipoAdicionalController@getPorNome');
    $router->post('/', 'TipoAdicionalController@store');
    $router->put('/{codTipoAdicional}', 'TipoAdicionalController@update');
    $router->delete('/{codTipoAdicional}', 'TipoAdicionalController@destroy');
});

$router->group(['prefix' => 'usuario'], function () use ($router) {
    $router->get('/', 'UsuarioController@index');
    $router->get('/{codUsuario}', 'UsuarioController@show');
    $router->post('/', 'UsuarioController@store');
    $router->put('/{codUsuario}', 'UsuarioController@update');
    $router->delete('/{codUsuario}', 'UsuarioController@destroy');
    $router->post('/find', 'UsuarioController@findUser');
});

$router->group(['prefix' => 'vaga'], function () use ($router) {
    $router->get('/', 'VagaController@index');
    $router->get('/match/{codCandidato}/{codCurriculo}', 'VagaController@getMatch');
    $router->post('/', 'VagaController@store');
    $router->put('/{codVaga}', 'VagaController@update');
    $router->delete('/{codVaga}', 'VagaController@destroy');

    $router->get('/beneficio/{codBeneficio}', 'BeneficioController@show');
    $router->post('beneficio/', 'BeneficioController@store');
    $router->post('/beneficios', 'BeneficioController@criaBeneficios');
    $router->put('/beneficio/{codBeneficio}', 'BeneficioController@update');
    $router->put('/{codVaga}/beneficios', 'BeneficioController@editaBeneficios');
    $router->delete('/beneficio/{codBeneficio}', 'BeneficioController@destroy');

    $router->get('/{codVaga}/requisitos/', 'RequisitoVagaController@show');
    $router->post('/requisito', 'RequisitoVagaController@store');
    $router->post('/requisitos', 'RequisitoVagaController@criaRequisitos');
    $router->put('/requisito/{codRequisito}', 'RequisitoVagaController@update');
    $router->put('/{codVaga}/requisitos', 'RequisitoVagaController@editaRequisitos');
    $router->delete('/requisito/{codRequisito}', 'RequisitoVagaController@destroy');
});
