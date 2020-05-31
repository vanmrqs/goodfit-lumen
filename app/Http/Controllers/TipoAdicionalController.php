<?php


namespace App\Http\Controllers;


use App\TipoAdicional;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TipoAdicionalController extends Controller{
    /**
     * Retorna todos os tipos
     * cadastrados
     *
     * @return TipoAdicional[]|Collection
     */
    public function index(){
        return TipoAdicional::all();
    }

    /**
     * Retorna um tipo pelo código
     *
     * @param int $codTipoAdicional
     * @return mixed
     */
    public function show(int $codTipoAdicional){
        return TipoAdicional::find($codTipoAdicional);
    }

    /**
     * Cria um novo tipo
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $tipoAdicional = $this->validate($request, TipoAdicional::$rules);
        TipoAdicional::create($tipoAdicional);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Atualiza um tipo
     *
     * @param Request $request
     * @param int $codTipoAdicional
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $codTipoAdicional){
        $this->validate($request, TipoAdicional::$rules);

        $tipoAdicional = TipoAdicional::findOrFail($codTipoAdicional);
        $tipoAdicional->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui um tipo
     *
     * @param int $codTipoAdicional
     * @return JsonResponse
     */
    public function destroy(int $codTipoAdicional){
        TipoAdicional::destroy($codTipoAdicional);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Retorna um tipo pelo nome
     *
     * @param string $nomeTipo
     * @return mixed
     */
    public function getPorNome(string $nomeTipo){
        return TipoAdicional::where('tbTipoAdicional.nomeTipoAdicional', $nomeTipo)->get();
    }
}
