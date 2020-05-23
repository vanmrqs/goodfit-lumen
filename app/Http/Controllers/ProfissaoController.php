<?php


namespace App\Http\Controllers;


use App\Profissao;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProfissaoController extends Controller {
    /**
     * Retorna todas as profissões
     * cadastradas
     *
     * @return Profissao[]|Collection
     */
    public function index(){
        return Profissao::all();
    }

    /**
     * Retorna uma profissão pelo id
     *
     * @param int $codProfissao
     * @return mixed
     */
    public function show(int $codProfissao){
        return Profissao::find($codProfissao);
    }

    /**
     * Cadastra uma profissão
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request){
        $profissao = $this->validate($request, Profissao::$rules);

        Profissao::create($profissao);
    }

    /**
     * Atualiza uma profissão
     *
     * @param Request $request
     * @param int $codProfissao
     * @throws ValidationException
     */
    public function update(Request $request, int $codProfissao){
        $this->validate($request, Profissao::$rules);

        $profissao = Profissao::findOrFail($codProfissao);

        $profissao['nomeProfissao'] = $request->nomeProfissao;
        $profissao['codCategoria']  = $request->codCategoria;
        $profissao->save();
    }

    /**
     * Exclui uma profissão
     *
     * @param int $codProfissao
     */
    public function destroy(int $codProfissao){
        Profissao::destroy($codProfissao);
    }

    /**
     * Retorna todas as profissões de
     * uma categoria
     *
     * @param int $codCategoria
     * @return mixed
     */
    public function getPorCategoria(int $codCategoria){
        return Profissao::where('codCategoria', $codCategoria)->get();
    }
}
