<?php


namespace App\Http\Controllers;


use App\AdicionalCurriculo;
use App\CargoCurriculo;
use App\Categoria;
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

        // Adiciona cargos em um currículo
        $this->adicionaCargo($curriculo->codCurriculo, $request->cargoCurriculo);
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

        if ( $request->has('videoArquivo') ) {
            $this->deletaVideo($curriculo['videoCurriculo'], PASTA_UPLOADS);
            $request['videoCurriculo'] = $this->uploadVideo($request->videoArquivo, PASTA_UPLOADS);
        }

        // Edita os adicionais de um currículo (Escolaridade, alfabetização e habilidades)
        $this->editaAdicionais($curriculo->codCurriculo, $request->adicionalCurriculo);

        // Edita os cargos de um currículo (Categorias de profissão)
        $this->editaCargo($curriculo->codCurriculo, $request->cargoCurriculo);

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

    /**
     * Edita os adicionais de um currículo
     *
     * @param int $codCurriculo
     * @param array $adicionais
     */
    private function editaAdicionais(int $codCurriculo, array $adicionais){
        $adicionaisExistentes = array_map(
            function($i){
                return (int)$i['codAdicional'];
            }, AdicionalCurriculo::where('tbAdicionalCurriculo.codCurriculo', '=', $codCurriculo)->get()->toArray()
        );

        $this->criaAdicionais($codCurriculo, array_diff($adicionais, $adicionaisExistentes));
        $this->removeAdicionais($codCurriculo, array_diff($adicionaisExistentes, $adicionais));
    }

    /**
     * Adiciona cargos (categorias de profissão)
     * em um currículo
     *
     * @param int $codCurriculo
     * @param array $cargos
     */
    private function adicionaCargo(int $codCurriculo, array $cargos){
        $cargo = [];
        $cargo['codCurriculo'] = $codCurriculo;
        foreach ( $cargos as $codCategoria ) {
            $cargo['codCategoria'] = $codCategoria;
            CargoCurriculo::create($cargo);
        }
    }

    /**
     * @param int $codCurriculo
     * @param array $cargos
     */
    private function removeCargo(int $codCurriculo, array $cargos){
        foreach ( $cargos as $codCategoria ) {
            $cargo = Categoria::where([
                ['codCurriculo', $codCurriculo],
                ['codCategoria', $codCategoria]
            ])->first();

            CargoCurriculo::destroy($cargo->codCargoCurriculo);
        }
    }

    /**
     * Edita os cargos de um currículo
     *
     * @param int $codCurriculo
     * @param array $cargos
     */
    private function editaCargo(int $codCurriculo, array $cargos){
        $cargosExistentes = array_map(
            function($i){
                return (int)$i['codAdicional'];
            }, CargoCurriculo::where('tbCargoCurriculo.codCurriculo', '=', $codCurriculo)->get()->toArray()
        );

        $this->adicionaCargo($codCurriculo, array_diff($cargos, $cargosExistentes));
        $this->removeCargo($codCurriculo, array_diff($cargosExistentes, $cargos));
    }
}
