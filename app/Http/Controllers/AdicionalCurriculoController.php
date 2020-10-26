<?php


namespace App\Http\Controllers;


use App\Adicional;
use App\AdicionalCurriculo;
use App\Http\Helper\UsuarioHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdicionalCurriculoController extends Controller {
    private $model;
    public function __construct(){
        $this->model = new AdicionalCurriculo();
    }

    /**
     * Retorna um adicional de um
     * currículo pelo código
     *
     * @param int $codAdicionalCurriculo
     * @return mixed
     */
    public function show($codAdicionalCurriculo){
        return AdicionalCurriculo::find($codAdicionalCurriculo);
    }

    /**
     * Cadastra um novo adicional em
     * um currículo
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $adicionalCurriculo = $this->validate($request, AdicionalCurriculo::$rules);
        AdicionalCurriculo::create($adicionalCurriculo);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Remove um adicional de um currículo
     *
     * @param int $codAdicionalCurriculo
     * @return JsonResponse
     */
    public function destroy($codAdicionalCurriculo){
        AdicionalCurriculo::destroy($codAdicionalCurriculo);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Cria adicionais em um currículo
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function criaAdicionais(Request $request){
        $this->criaEmLote($request, 'codCurriculo', 'adicionais', 'codAdicional', $this->model);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Remove adicionais de um currículo
     *
     * @param int $codCurriculo
     * @param array $adicionais
     */
    private function removeAdicionais(int $codCurriculo, array $adicionais){
        $this->removeEmLote($codCurriculo, 'codCurriculo', $adicionais, 'codAdicional', $this->model);
    }

    /**
     * Edita os adicionais de um currículo
     *
     * @param Request $request
     * @param int $codCurriculo
     * @return JsonResponse
     */
    public function editaAdicionais(Request $request, int $codCurriculo){
        $adicionais = $request->adicionais;

        $adicionaisExistentes = $this->getItensExistentes($codCurriculo, 'codCurriculo', 'codAdicional', $this->model);

        $this->criaAdicionais($this->criaRequestAdicional($codCurriculo, array_diff($adicionais, $adicionaisExistentes)));
        $this->removeAdicionais($codCurriculo, array_diff($adicionaisExistentes, $adicionais));
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Retorna os adicionais de um candidato
     *
     * @param Request $request
     * @return mixed
     */
    public function getAdicionaisPorCandidato(Request $request) {
        return Adicional::join('tbAdicionalCurriculo', 'tbAdicional.codAdicional', 'tbAdicionalCurriculo.codAdicional')
            ->join('tbCurriculo', 'tbAdicionalCurriculo.codCurriculo', 'tbCurriculo.codCurriculo')
            ->join('tbCandidato', 'tbCurriculo.codCandidato', 'tbCandidato.codCandidato')
            ->where('tbCandidato.codCandidato', $request->codCandidato);
    }

    /**
     * Cria um objeto do tipo request com
     * dados de AdicionalCurriculo
     *
     * @param int $codCurriculo
     * @param array $adicionais
     * @return Request
     */
    private function criaRequestAdicional(int $codCurriculo, array $adicionais){
        $adicionar = [];
        $adicionar['codCurriculo'] = $codCurriculo;
        $adicionar['adicionais']   = $adicionais;

        return new Request($adicionar);
    }
}
