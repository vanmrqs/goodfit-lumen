<?php


namespace App\Http\Controllers;


use App\AdicionalCurriculo;
use App\Curriculo;
use Illuminate\Database\Eloquent\Collection;
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
     * @throws ValidationException
     */
    public function store(Request $request){
        if ( $request->has('videoArquivo') ) {
            $request['videoCurriculo'] = $this->uploadVideo($request->videoArquivo, PASTA_UPLOADS);
        }

        $curriculo = $this->validate($request, Curriculo::$rules);
        $curriculo = Curriculo::create($curriculo);

        $adicionais = [];
        $adicionais[] = $request->escolaridadeCurriculo;
        $adicionais[] = $request->alfabetizacaoCurriculo;
        foreach ( $request->habilidadeCurriculo as $codAdicional ) {
            $adicionais[] = $codAdicional;
        }

        // Cria adicionais de curriculo (Escolaridade, alfabetização e habilidades)
        $adicional = [];
        $adicional['codCurriculo'] = $curriculo->codCurriculo;
        foreach ( $adicionais as $codAdicional ) {
            $adicional['codAdicional'] = $codAdicional;

            AdicionalCurriculo::create($adicional);
        }
    }
}
