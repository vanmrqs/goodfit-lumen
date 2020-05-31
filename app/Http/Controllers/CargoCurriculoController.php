<?php


namespace App\Http\Controllers;


use App\CargoCurriculo;
use App\Categoria;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CargoCurriculoController extends Controller {
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
     * @throws ValidationException
     */
    public function store(Request $request){
        $cargo = $this->validate($request, CargoCurriculo::$rules);
        CargoCurriculo::create($cargo);
    }

    /**
     * Remove um cargo (categoria) de
     * um currículo
     *
     * @param $codCargoCurriculo
     */
    public function destroy($codCargoCurriculo){
        CargoCurriculo::destroy($codCargoCurriculo);
    }

    /**
     * Adiciona cargos (categorias de profissão)
     * em um currículo
     *
     * @param Request $request
     */
    public function adicionaCargos(Request $request){
        $classe = new CargoCurriculo();
        $this->criaEmLote($request, 'codCurriculo', 'cargos', 'codCategoria', $classe);
    }

    /**
     * @param int $codCurriculo
     * @param array $cargos
     */
    private function removeCargos(int $codCurriculo, array $cargos){
        $classe = new CargoCurriculo();
        $this->removeEmLote($codCurriculo, 'codCurriculo', $cargos, 'codCategoria', $classe);
    }

    /**
     * Edita os cargos de um currículo
     *
     * @param Request $request
     * @param int $codCurriculo
     */
    public function editaCargos(Request $request, int $codCurriculo){
        $cargos = $request->cargos;

        $cargosExistentes = array_map(
            function($i){
                return (int)$i['codCategoria'];
            }, CargoCurriculo::where('tbCargoCurriculo.codCurriculo', $codCurriculo)->get()->toArray()
        );

        $this->adicionaCargos($this->criaRequestCargos($codCurriculo, array_diff($cargos, $cargosExistentes)));
        $this->removeCargos($codCurriculo, array_diff($cargosExistentes, $cargos));
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
