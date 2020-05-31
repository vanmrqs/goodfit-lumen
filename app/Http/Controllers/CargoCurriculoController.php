<?php


namespace App\Http\Controllers;


use App\CargoCurriculo;
use App\Categoria;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CargoCurriculoController extends Controller {
    private $model;
    public function __construct(){
        $this->model = new CargoCurriculo();
    }

    /**
     * Retorna um cargo em
     * um currículo
     *
     * @param $codCargoCurriculo
     * @return CargoCurriculo[]|Collection
     */
    public function show($codCargoCurriculo){
        return CargoCurriculo::find($codCargoCurriculo);
    }

    /**
     * Adiciona uma cargo (categoria)
     * em um currículo
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $cargo = $this->validate($request, CargoCurriculo::$rules);
        CargoCurriculo::create($cargo);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Remove um cargo (categoria) de
     * um currículo
     *
     * @param $codCargoCurriculo
     * @return JsonResponse
     */
    public function destroy($codCargoCurriculo){
        CargoCurriculo::destroy($codCargoCurriculo);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Adiciona cargos (categorias de profissão)
     * em um currículo
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function adicionaCargos(Request $request){
        $this->criaEmLote($request, 'codCurriculo', 'cargos', 'codCategoria', $this->model);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * @param int $codCurriculo
     * @param array $cargos
     */
    private function removeCargos(int $codCurriculo, array $cargos){
        $this->removeEmLote($codCurriculo, 'codCurriculo', $cargos, 'codCategoria', $this->model);
    }

    /**
     * Edita os cargos de um currículo
     *
     * @param Request $request
     * @param int $codCurriculo
     * @return JsonResponse
     */
    public function editaCargos(Request $request, int $codCurriculo){
        $cargos = $request->cargos;

        $cargosExistentes = $this->getItensExistentes($codCurriculo, 'codCurriculo', 'codCategoria', $this->model);

        $this->adicionaCargos($this->criaRequestCargos($codCurriculo, array_diff($cargos, $cargosExistentes)));
        $this->removeCargos($codCurriculo, array_diff($cargosExistentes, $cargos));
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Cria um objeto request com dados
     * de CargoCurriculo
     *
     * @param int $codCurriculo
     * @param array $cargos
     * @return Request
     */
    private function criaRequestCargos(int $codCurriculo, array $cargos){
        $cargo = [];
        $cargo['codCurriculo'] = $codCurriculo;
        $cargo['cargos']       = $cargos;

        return new Request($cargo);
    }
}
