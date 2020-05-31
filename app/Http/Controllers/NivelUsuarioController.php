<?php


namespace App\Http\Controllers;

use App\NivelUsuario;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
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
        return NivelUsuario::find($codNivelUsuario);
    }

    /**
     * Cria um novo nível de usuário
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $nivelUsuario = $this->validate($request, NivelUsuario::$rules);
        NivelUsuario::create($nivelUsuario);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Atualiza um nível de usuário
     *
     * @param Request $request
     * @param $codNivelUsuario
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $codNivelUsuario){
        $this->validate($request, NivelUsuario::$rules);

        $nivelUsuario = NivelUsuario::findOrFail($codNivelUsuario);
        $nivelUsuario->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui um nível de usuário
     *
     * @param $codNivelUsuario
     * @return JsonResponse
     */
    public function destroy($codNivelUsuario){
        NivelUsuario::destroy($codNivelUsuario);
        return response()->json(['message' => 'success'], 200);
    }
}
