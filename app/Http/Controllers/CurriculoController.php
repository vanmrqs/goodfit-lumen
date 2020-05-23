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

        // Cria adicionais de curriculo (Escolaridade, alfabetização e habilidades)
        $this->criaAdicionais($curriculo->codCurriculo, $request->adicionalCurriculo);
    }

    /**
     * Atualiza um currículo
     *
     * @param Request $request
     * @param int $codCurriculo
     * @throws ValidationException
     */
    public function update(Request $request, int $codCurriculo){
        $this->validate($request, Curriculo::$rules);

        $curriculo  = Curriculo::findOrFail($codCurriculo);

        // Edita os adicionais de um currículo (Escolaridade, alfabetização e habilidades)
        $adicionaisExistentes = array_map(function($i){return (int)$i['codAdicional'];}, AdicionalCurriculo::where('tbAdicionalCurriculo.codCurriculo', '=', $codCurriculo)->get()->toArray());
        $this->criaAdicionais($curriculo->codCurriculo, array_diff($request->adicionalCurriculo, $adicionaisExistentes));
        $this->removeAdicionais($curriculo->codCurriculo, array_diff($adicionaisExistentes, $request->adicionalCurriculo));

        if ( $request->has('videoArquivo') ) {
            $this->deletaVideo($curriculo['videoCurriculo'], PASTA_UPLOADS);
            $request['videoCurriculo'] = $this->uploadVideo($request->videoArquivo, PASTA_UPLOADS);
        }

        $curriculo['videoCurriculo']     = $request->videoCurriculo;
        $curriculo['descricaoCurriculo'] = $request->descricaoCurriculo;
        $curriculo['codCandidato']       = $request->codCandidato;
        $curriculo->save();
    }

    /**
     * Exclui um currículo
     *
     * @param int $codCurriculo
     */
    public function destroy(int $codCurriculo){
        Curriculo::destroy($codCurriculo);
    }

    /**
     * Cria adicionais em um currículo
     *
     * @param int $codCurriculo
     * @param array $adicionais
     */
    private function criaAdicionais(int $codCurriculo, array $adicionais){
        $adicional = [];
        $adicional['codCurriculo'] = $codCurriculo;
        foreach ( $adicionais as $codAdicional ) {
            $adicional['codAdicional'] = $codAdicional;
            AdicionalCurriculo::create($adicional);
        }
    }

    /**
     * Remove adicionais de um currículo
     *
     * @param int $codCurriculo
     * @param array $adicionais
     */
    private function removeAdicionais(int $codCurriculo, array $adicionais){
        foreach ( $adicionais as $codAdicional ) {
            $adicional = AdicionalCurriculo::where([
                ['tbAdicionalCurriculo.codCurriculo', $codCurriculo],
                ['tbAdicionalCurriculo.codAdicional', $codAdicional]
            ])->first();

            AdicionalCurriculo::destroy($adicional->codAdicionalCurriculo);
        }
    }
}
