<?php


namespace App\Http\Controllers;


use App\CargoCurriculo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CargoCurriculoController extends Controller {
    /**
     * Retorna um cargo em
     * um currículo
     *
     * @param $codCargoCurriculo
     * @return CargoCurriculo[]|Collection
     */
    public function show($codCargoCurriculo){
        return CargoCurriculo::findOrFail($codCargoCurriculo);
    }

    /**
     * Adiciona uma cargo (categoria)
     * em um currículo
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request){
        $cargo = $this->validate($request, CargoCurriculo::$rules);
        CargoCurriculo::create($cargo);
    }

    /**
     * Remove um cargo (categoria) de
     * um currículo
     *
     * @param $codCargoCurriculo
     */
    public function destroy($codCargoCurriculo){
        CargoCurriculo::findOrFail($codCargoCurriculo)->delete();
    }
}
