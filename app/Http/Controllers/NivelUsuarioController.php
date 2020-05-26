<?php


namespace App\Http\Controllers;

use App\NivelUsuario;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

define('NIVEL_MODERADOR', 1);
define('NIVEL_CANDIDATO', 2);
define('NIVEL_EMPRESA', 3);

class NivelUsuarioController extends Controller {
    /**
     * Retorna todos os níveis de
     * usuário cadastrados no sistema
     *
     * @return NivelUsuario[]|Collection
     */
    public function index(){
        return NivelUsuario::all();
    }

    /**
     * Retorna um nível de usuário específico
     *
     * @param $codNivelUsuario
     * @return mixed
     */
    public function show($codNivelUsuario){
        return NivelUsuario::find($codNivelUsuario);
    }

    /**
     * Cria um novo nível de usuário
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request){
        $nivelUsuario = $this->validate($request, NivelUsuario::$rules);
        NivelUsuario::create($nivelUsuario);
    }

    /**
     * Atualiza um nível de usuário
     *
     * @param Request $request
     * @param $codNivelUsuario
     * @throws ValidationException
     */
    public function update(Request $request, $codNivelUsuario){
        $this->validate($request, NivelUsuario::$rules);

        $nivelUsuario = NivelUsuario::findOrFail($codNivelUsuario);
        $nivelUsuario->nomeNivelUsuario = $request->nomeNivelUsuario;
        $nivelUsuario->save();
    }

    /**
     * Exclui um nível de usuário
     *
     * @param $codNivelUsuario
     */
    public function destroy($codNivelUsuario){
        NivelUsuario::destroy($codNivelUsuario);
    }
}
