<?php


namespace App\Http\Controllers;


use App\Empresa;
use App\Endereco;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $empresa = $this->validate($request, Empresa::$rules);
        Empresa::create($empresa);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Atualiza uma empresa
     *
     * @param Request $request
     * @param int $codEmpresa
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $codEmpresa){
        $this->validate($request, Empresa::$rules);

        $empresa = Empresa::findOrFail($codEmpresa);
        $empresa->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui uma empresa
     *
     * @param int $codEmpresa
     * @return JsonResponse
     */
    public function destroy(int $codEmpresa){
        Empresa::destroy($codEmpresa);
        return response()->json(['message' => 'success'], 200);
    }
}
