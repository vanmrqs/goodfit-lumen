<?php


namespace App\Http\Controllers;


use App\Beneficio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BeneficioController extends Controller {
    private $model;
    public function __construct(){
        $this->model = new Beneficio();
    }

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
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $beneficio = $this->validate($request, Beneficio::$rules);
        Beneficio::create($beneficio);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Atualiza o benefício de uma
     * vaga
     *
     * @param Request $request
     * @param $codBeneficio
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $codBeneficio){
        $this->validate($request, Beneficio::$rules);

        $beneficio = Beneficio::findOrFail($codBeneficio);
        $beneficio->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Remove um benefício de uma
     * vaga
     *
     * @param $codBeneficio
     * @return JsonResponse
     */
    public function destroy(int $codBeneficio){
        Beneficio::destroy($codBeneficio);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Cria benefícios em uma vaga
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function criaBeneficios(Request $request){
        $this->criaEmLote($request, 'codVaga', 'beneficios', 'nomeBeneficio', $this->model);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Remove os benefícios de uma vaga
     *
     * @param int $codVaga
     * @param array $beneficios
     */
    public function removeBeneficios(int $codVaga, array $beneficios){
        $this->removeEmLote($codVaga, 'codVaga', $beneficios, 'nomeBeneficio', $this->model);
    }

    /**
     * Edita os benefícios de uma vaga
     *
     * @param Request $request
     * @param int $codVaga
     * @return JsonResponse
     */
    public function editaBeneficios(Request $request, int $codVaga){
        $beneficios = $request->beneficios;

        $beneficiosExistentes = $this->getItensExistentes($codVaga, 'codVaga', 'nomeBeneficio', $this->model);

        $this->criaBeneficios($this->criaBeneficioRequest($codVaga, array_diff($beneficios, $beneficiosExistentes)));;
        $this->removeBeneficios($codVaga, array_diff($beneficiosExistentes, $beneficios));
        return response()->json(['message' => 'success'], 200);
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
