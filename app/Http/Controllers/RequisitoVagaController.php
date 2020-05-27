<?php


namespace App\Http\Controllers;


use App\AdicionalCurriculo;
use App\RequisitoVaga;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RequisitoVagaController extends Controller {
    /**
     * Retorna um requisito pelo código
     *
     * @param int $codRequisitoVaga
     * @return mixed
     */
    public function show(int $codRequisitoVaga){
        return RequisitoVaga::find($codRequisitoVaga);
    }

    /**
     * Adiciona um novo requisito
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request){
        $requisito = $this->validate($request, RequisitoVaga::$rules);
        RequisitoVaga::create($requisito);
    }

    /**
     * Atualiza um requisito
     *
     * @param Request $request
     * @param int $codRequisitoVaga
     * @throws ValidationException
     */
    public function update(Request $request, int $codRequisitoVaga){
        $this->validate($request, RequisitoVaga::$rules);

        $requisito = RequisitoVaga::findOrFail($codRequisitoVaga);
        $requisito['obrigatoriedadeRequisitoVaga'] = $request->obrigatoriedadeRequisitoVaga;
        $requisito->save();
    }

    /**
     * Exclui um requisito
     *
     * @param int $codRequisitoVaga
     */
    public function destroy(int $codRequisitoVaga){
        RequisitoVaga::destroy($codRequisitoVaga);
    }
}
