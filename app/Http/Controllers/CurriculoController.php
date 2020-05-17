<?php


namespace App\Http\Controllers;


use App\Curriculo;
use Illuminate\Database\Eloquent\Collection;

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
        return Curriculo::findOrFail($codCurriculo);
    }
}
