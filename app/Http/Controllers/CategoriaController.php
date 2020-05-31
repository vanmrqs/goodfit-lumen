<?php


namespace App\Http\Controllers;


use App\Categoria;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

define('PASTA_IMAGENS', 'categoria');

class CategoriaController extends Controller {
    /**
     * Retorna todas as categorias
     * cadastradas
     *
     * @return Categoria[]|Collection
     */
    public function index(){
        return Categoria::all();
    }

    /**
     * Retorna uma categoria pelo
     * código
     *
     * @param int $codCategoria
     * @return mixed
     */
    public function show(int $codCategoria){
        return Categoria::find($codCategoria);
    }

    /**
     * Cadastra uma nova categoria
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $categoria = $this->validate($request, Categoria::$rules);

        if ( $request->has('imagemCategoria') ) {
            $categoria['imagemCategoria'] = $this->uploadImagem($request->imagemCategoria, 300, 300, PASTA_IMAGENS);
        }

        Categoria::create($categoria);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Atualiza uma categoria
     *
     * @param Request $request
     * @param $codCategoria
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $codCategoria){
        $this->validate($request, Categoria::$rules);

        $categoria = Categoria::findOrFail($codCategoria);

        if ( $request->has('imagemCategoria') ) {
            $this->deletaImagem($categoria['imagemCategoria'], PASTA_IMAGENS);
            $request->imagemCategoria = $this->uploadImagem($request->imagemCategoria, 300, 300, PASTA_IMAGENS);
        }

        $categoria->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui uma categoria
     *
     * @param int $codCategoria
     * @return JsonResponse
     */
    public function destroy(int $codCategoria){
        //TODO: Excluir cargoCurriculo
        Categoria::destroy($codCategoria);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Retorna as categorias de
     * um currículo
     *
     * @param int $codCurriculo
     * @return mixed
     */
    public function getPorCurriculo(int $codCurriculo){
        return Categoria::join('tbCargoCurriculo', 'tbCategoria.codCategoria', '=', 'tbCargoCurriculo.codCategoria')
            ->where('tbCargoCurriculo.codCurriculo', $codCurriculo)
            ->orderBy('tbCategoria.nomeCategoria')
            ->get();
    }
}
