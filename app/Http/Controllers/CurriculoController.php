<?php


namespace App\Http\Controllers;


use App\AdicionalCurriculo;
use App\Curriculo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

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

    // TODO: terminar dps de criar todos os controllers
    public function store(Request $request){
        $curriculo = $this->validate($request, Curriculo::$rules);
        $curriculo = Curriculo::create($curriculo);

        $adicionais = [];
        $adicionais[] = $request->escolaridadeCurriculo;
        $adicionais[] = $request->alfabetizacaoCurriculo;
        foreach ( $request->habilidadeCurriculo as $codAdicional ) {
            $adicionais[] = $codAdicional;
        }

        // Adiciona adicionais de curriculo (Escolaridade, alfabetização e habilidades)
        $adicional = [];
        $adicional['codCurriculo'] = $curriculo->codCurriculo;
        foreach ( $adicionais as $codAdicional ) {
            $adicional['codAdicional'] = $codAdicional;

            AdicionalCurriculo::create($adicional);
        }
    }
}
