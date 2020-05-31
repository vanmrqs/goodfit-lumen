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
    public function show(int $codBeneficio){
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
    public function update(Request $request, int $codBeneficio){
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
    public function destroy(int $codBeneficio){
        Beneficio::destroy($codBeneficio);
    }

    /**
     * Cria benefícios em uma vaga
     *
     * @param Request $request
     */
    public function criaBeneficios(Request $request){
        $classe = new Beneficio();
        $this->criaEmLote($request, 'codVaga', 'beneficios', 'nomeBeneficio', $classe);
    }

    /**
     * Remove os benefícios de uma vaga
     *
     * @param int $codVaga
     * @param array $beneficios
     */
    public function removeBeneficios(int $codVaga, array $beneficios){
        $classe = new Beneficio();
        $this->removeEmLote($codVaga, 'codVaga', $beneficios, 'nomeBeneficio', $classe);
    }

    /**
     * Edita os benefícios de uma vaga
     *
     * @param Request $request
     * @param int $codVaga
     */
    public function editaBeneficios(Request $request, int $codVaga){
        $beneficios = $request->beneficios;

        $beneficiosExistentes = array_map(function($i){
            return (int)$i['nomeBeneficio'];
        }, Beneficio::where('codaVaga', $codVaga)->get()->toArray());

        $this->criaBeneficios($this->criaBeneficioRequest($codVaga, array_diff($beneficios, $beneficiosExistentes)));;
        $this->removeBeneficios($codVaga, array_diff($beneficiosExistentes, $beneficios));
    }

    /**
     * Cria um request do tipo benefício
     *
     * @param int $codVaga
     * @param array $beneficios
     * @return Request
     */
    private function criaBeneficioRequest(int $codVaga, array $beneficios){
        $request = [];
        $request['codVaga']    = $codVaga;
        $request['beneficios'] = $beneficios;

        return new Request($request);
    }

    /**
     * Retorna os benefícios de uma
     * vaga
     *
     * @param int $codVaga
     * @return mixed
     */
    public function getPorVaga(int $codVaga){
        return Beneficio::where('codVaga', $codVaga)->get();
    }
}
