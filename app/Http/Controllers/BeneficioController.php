<?php


namespace App\Http\Controllers;


use App\Beneficio;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BeneficioController extends Controller {
    /**
     * Retorna um benefício pelo
     * código
     *
     * @param int $codBeneficio
     * @return mixed
     */
    public function show($codBeneficio){
        return Beneficio::find($codBeneficio);
    }

    /**
     * Adiciona um benefício em uma
     * vaga
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request){
        $beneficio = $this->validate($request, Beneficio::$rules);
        Beneficio::create($beneficio);
    }

    /**
     * Atualiza o benefício de uma
     * vaga
     *
     * @param Request $request
     * @param $codBeneficio
     * @throws ValidationException
     */
    public function update(Request $request, $codBeneficio){
        $this->validate($request, Beneficio::$rules);

        $beneficio = Beneficio::findOrFail($codBeneficio);
        $beneficio['nomeBeneficio'] = $request->nomeBeneficio;
        $beneficio->save();
    }

    /**
     * Remove um benefício de uma
     * vaga
     *
     * @param $codBeneficio
     */
    public function destroy($codBeneficio){
        Beneficio::destroy($codBeneficio);
    }

    /**
     * Retorna os benefícios de uma
     * vaga
     *
     * @param int $codVaga
     * @return mixed
     */
    public function getPorVaga($codVaga){
        return Beneficio::where('codVaga', $codVaga)->get();
    }
}
