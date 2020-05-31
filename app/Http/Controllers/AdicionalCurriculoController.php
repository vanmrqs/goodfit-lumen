<?php


namespace App\Http\Controllers;


use App\AdicionalCurriculo;
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
     * @throws ValidationException
     */
    public function store(Request $request){
        $adicionalCurriculo = $this->validate($request, AdicionalCurriculo::$rules);
        AdicionalCurriculo::create($adicionalCurriculo);
    }

    /**
     * Remove um adicional de um currículo
     *
     * @param int $codAdicionalCurriculo
     */
    public function destroy($codAdicionalCurriculo){
        AdicionalCurriculo::destroy($codAdicionalCurriculo);
    }

    /**
     * Cria adicionais em um currículo
     *
     * @param Request $request
     */
    public function criaAdicionais(Request $request){
        $this->criaEmLote($request, 'codCurriculo', 'adicionais', 'codAdicional', $this->model);
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
     */
    public function editaAdicionais(Request $request, int $codCurriculo){
        $adicionais = $request->adicionais;

        $adicionaisExistentes = $this->getItensExistentes($codCurriculo, 'codCurriculo', 'codAdicional', $this->model);

        $this->criaAdicionais($this->criaRequestAdicional($codCurriculo, array_diff($adicionais, $adicionaisExistentes)));
        $this->removeAdicionais($codCurriculo, array_diff($adicionaisExistentes, $adicionais));
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
