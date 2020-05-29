<?php


namespace App\Http\Controllers;


use App\AdicionalCurriculo;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class AdicionalCurriculoController extends Controller {
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
        $codCurriculo = $request->codCurriculo;
        $adicionais   = $request->adicionais;

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
     * @param Request $request
     * @param int $codCurriculo
     */
    public function editaAdicionais(Request $request, int $codCurriculo){
        $adicionais = $request->adicionais;

        $adicionaisExistentes = array_map(
            function($i){
                return (int)$i['codAdicional'];
            }, AdicionalCurriculo::where('tbAdicionalCurriculo.codCurriculo', '=', $codCurriculo)->get()->toArray()
        );

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
