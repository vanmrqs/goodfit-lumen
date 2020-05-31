<?php


namespace App\Http\Controllers;

use App\Curriculo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

define('PASTA_UPLOADS', 'curriculo');

class CurriculoController extends Controller {
    /**
     * Retorna os currículos
     * cadastrados
     *
     * @return Curriculo[]|Collection
     */
    public function index(){
        return Curriculo::all();
    }

    /**
     * Retorna um currículo
     *
     * @param int $codCurriculo
     * @return mixed
     */
    public function show(int $codCurriculo){
        return Curriculo::find($codCurriculo);
    }

    /**
     * Criando um currículo e salvando seus
     * adicionais
     *
     * @param Request $request
     * @return int
     * @throws ValidationException
     */
    public function store(Request $request){
        if ( $request->has('videoArquivo') ) {
            $request['videoCurriculo'] = $this->uploadVideo($request->videoArquivo, PASTA_UPLOADS);
        }

        $curriculo = $this->validate($request, Curriculo::$rules);
        $curriculo = Curriculo::create($curriculo);

        return $curriculo->codCurriculo;
    }

    /**
     * Atualiza um currículo
     *
     * @param Request $request
     * @param int $codCurriculo
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $codCurriculo){
        $this->validate($request, Curriculo::$rules);

        $curriculo  = Curriculo::findOrFail($codCurriculo);

        if ( $request->has('videoArquivo') ) {
            $this->deletaVideo($curriculo['videoCurriculo'], PASTA_UPLOADS);
            $request['videoCurriculo'] = $this->uploadVideo($request->videoArquivo, PASTA_UPLOADS);
        }

        $curriculo->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui um currículo
     *
     * @param int $codCurriculo
     * @return JsonResponse
     */
    public function destroy(int $codCurriculo){
        Curriculo::destroy($codCurriculo);
        return response()->json(['message' => 'success'], 200);
    }
}
