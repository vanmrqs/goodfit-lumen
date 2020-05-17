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
        return AdicionalCurriculo::findOrFail($codAdicionalCurriculo);
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
        AdicionalCurriculo::findOrFail($codAdicionalCurriculo)->delete();
    }
}
