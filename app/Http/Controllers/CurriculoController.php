<?php


namespace App\Http\Controllers;


use App\Curriculo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Client\Request;

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
    }
}
