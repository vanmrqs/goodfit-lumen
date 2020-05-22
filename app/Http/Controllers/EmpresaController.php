<?php


namespace App\Http\Controllers;


use App\Empresa;
use App\Endereco;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmpresaController extends Controller {
    /**
     * Retorna todas as empresas cadastradas
     *
     * @return Empresa[]|Collection
     */
    public function index(){
        return Empresa::all();
    }

    /**
     * Retorna uma empresa pelo código
     *
     * @param int $codEmpresa
     * @return mixed
     */
    public function show(int $codEmpresa){
        return Empresa::find($codEmpresa);
    }

    /**
     * Cria uma nova empresa
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request){
        $empresa = $this->validate($request, Empresa::$rules);
        Empresa::create($empresa);
    }

    /**
     * Atualiza uma empresa
     *
     * @param Request $request
     * @param int $codEmpresa
     * @throws ValidationException
     */
    public function update(Request $request, int $codEmpresa){
        $this->validate($request, Empresa::$rules);

        $empresa = Empresa::findOrFail($codEmpresa);
        $empresa['razaoSocialEmpresa'] = $request->razaoSocialEmpresa;
        $empresa['nomeFantasiaEmpresa'] = $request->nomeFantasiaEmpresa;
        $empresa['cnpjEmpresa'] = $request->cnpjEmpresa;
        $empresa['codUsuario'] = $request->codUsuario;
        $empresa->save();
    }

    /**
     * Exclui uma empresa
     *
     * @param int $codEmpresa
     */
    public function destroy(int $codEmpresa){
        Empresa::destroy($codEmpresa);
    }
}
