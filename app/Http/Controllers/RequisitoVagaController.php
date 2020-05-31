<?php


namespace App\Http\Controllers;


use App\AdicionalCurriculo;
use App\RequisitoVaga;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $requisito = $this->validate($request, RequisitoVaga::$rules);
        RequisitoVaga::create($requisito);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Atualiza um requisito
     *
     * @param Request $request
     * @param int $codRequisitoVaga
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $codRequisitoVaga){
        $this->validate($request, RequisitoVaga::$rules);

        $requisito = RequisitoVaga::findOrFail($codRequisitoVaga);
        $requisito['obrigatoriedadeRequisitoVaga'] = $request->obrigatoriedadeRequisitoVaga;
        $requisito->save();
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui um requisito
     *
     * @param int $codRequisitoVaga
     * @return JsonResponse
     */
    public function destroy(int $codRequisitoVaga){
        RequisitoVaga::destroy($codRequisitoVaga);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Cria requisitos em uma vaga
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function criaRequisitos(Request $request){
        $novoRequisito = [];
        $novoRequisito['codVaga'] = $request->codVaga;

        foreach ( $request->requisitos as $requisito ) {
            if ( gettype($requisito) == 'object' ) {
                $requisito = (array)$requisito;
            }

            $novoRequisito['codAdicional']                 = $requisito['codAdicional'];
            $novoRequisito['obrigatoriedadeRequisitoVaga'] = $requisito['obrigatoriedade'];
            RequisitoVaga::create($novoRequisito);
        }
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Remove requisitos de uma vaga
     *
     * @param int $codVaga
     * @param array $requisitos
     * @return JsonResponse
     */
    private function removeRequisitos(int $codVaga, array $requisitos){
        $this->removeEmLote($codVaga, 'codVaga', $requisitos, 'codAdicional', new RequisitoVaga());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Edita os requisitos de uma vaga
     *
     * @param Request $request
     * @param int $codVaga
     * @return JsonResponse
     */
    public function editaRequisitos(Request $request, int $codVaga){
        $requisitos = $request->requisitos;

        $requisitosExistentes = array_map(function($requisito){
            $data = [];
            $data['codAdicional']                 = $requisito['codAdicional'];
            $data['obrigatoriedadeRequisitoVaga'] = $requisito['obrigatoriedadeRequisitoVaga'];

            return $data;
        }, RequisitoVaga::where('tbRequisitoVaga.codVaga', $codVaga)->get()->toArray());

        $this->criaRequisitos($this->criaRequisitoRequest($codVaga, $this->requisitosAdicionar($requisitos, $requisitosExistentes)));
        $this->removeRequisitos($codVaga, $this->requisitosRemover($requisitos, $requisitosExistentes));
        return response()->json(['message' => 'success'], 200);
    }

    private function criaRequisitoRequest(int $codVaga, array $requisitos){
        $requisito = [];
        $requisito['codVaga']    = $codVaga;
        $requisito['requisitos'] = $requisitos;

        return new Request($requisito);
    }

    /**
     * Verifica quais requisitos devem
     * ser adicionados na vaga
     *
     * @param array $requisitos
     * @param array $requisitosExistentes
     * @return mixed
     */
    private function requisitosAdicionar(array $requisitos, array $requisitosExistentes){
        $requisitosAdicionar = array_diff(
            array_map('json_encode', $requisitos),
            array_map('json_encode', $requisitosExistentes)
        );

        $retorno = [];
        foreach ( $requisitosAdicionar as $requisito ) {
            $retorno[] = json_decode($requisito);
        }

        return $retorno;
    }

    /**
     * Verifica quais requisitos devem
     * ser removidos da vaga
     *
     * @param array $requisitos
     * @param array $requisitosExistentes
     * @return mixed
     */
    private function requisitosRemover(array $requisitos, array $requisitosExistentes){
        $requisitosRemover = array_diff(
            array_map('json_encode', $requisitosExistentes),
            array_map('json_encode', $requisitos)
        );

        return array_map('json_decode', $requisitosRemover);
    }
}
