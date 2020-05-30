<?php


namespace App\Http\Controllers;


use App\RegimeContratacao;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegimeContratacaoController extends Controller {
    /**
     * Retorna todos os regimes
     * de contratação cadastrados
     *
     * @return RegimeContratacao[]|Collection
     */
    public function index(){
        return RegimeContratacao::all();
    }

    /**
     * Retorna um regime de contratação
     * pelo código
     *
     * @param int $codRegimeContratacao
     * @return mixed
     */
    public function show(int $codRegimeContratacao){
        return RegimeContratacao::find($codRegimeContratacao);
    }

    /**
     * Cadastra um novo regime de
     * contratação
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request){
        $regime = $this->validate($request, RegimeContratacao::$rules);
        RegimeContratacao::create($regime);
    }

    /**
     * Atualiza um regime de contratação
     *
     * @param Request $request
     * @param int $codRegimeContratacao
     * @throws ValidationException
     */
    public function update(Request $request, int $codRegimeContratacao){
        $this->validate($request, RegimeContratacao::$rules);

        $regime = RegimeContratacao::findOrFail($codRegimeContratacao);
        $regime['nomeRegimeContratacao'] = $request->nomeRegimeContratacao;
        $regime->save();
    }

    /**
     * Exclui um regime de contratação
     * pelo código
     *
     * @param int $codRegimeContratacao
     */
    public function destroy(int $codRegimeContratacao){
        RegimeContratacao::destroy($codRegimeContratacao);
    }
}
