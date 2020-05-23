<?php


namespace App\Http\Controllers;


use App\TipoAdicional;
use Illuminate\Database\Eloquent\Collection;
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
     * @throws ValidationException
     */
    public function store(Request $request){
        $tipoAdicional = $this->validate($request, TipoAdicional::$rules);
        TipoAdicional::create($tipoAdicional);
    }

    /**
     * Atualiza um tipo
     *
     * @param Request $request
     * @param int $codTipoAdicional
     * @throws ValidationException
     */
    public function update(Request $request, int $codTipoAdicional){
        $this->validate($request, TipoAdicional::$rules);

        $tipoAdicional = TipoAdicional::findOrFail($codTipoAdicional);
        $tipoAdicional['nomeTipoAdicional']        = $request->nomeTipoAdicional;
        $tipoAdicional['escalonavelTipoAdicional'] = $request->escalonavelTipoAdicional;
        $tipoAdicional->save();
    }

    /**
     * Exclui um tipo
     *
     * @param int $codTipoAdicional
     */
    public function destroy(int $codTipoAdicional){
        TipoAdicional::destroy($codTipoAdicional);
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
