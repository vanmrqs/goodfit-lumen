<?php


namespace App\Http\Controllers;

use App\NivelUsuario;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        return NivelUsuario::findOrFail($codNivelUsuario);
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
}
