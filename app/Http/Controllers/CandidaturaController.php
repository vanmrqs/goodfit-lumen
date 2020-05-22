<?php


namespace App\Http\Controllers;


use App\Candidatura;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

define('STATUS_APROVADO', 1);
define('STATUS_ANALISE', 2);
define('STATUS_RECUSADO', 3);

class CandidaturaController extends Controller {
    /**
     * Retorna todas as candidaturas
     * cadastradas
     *
     * @return Candidatura[]|Collection
     */
    public function index(){
        return Candidatura::all();
    }

    public function show($codCandidatura){
        return Candidatura::find($codCandidatura);
    }

    /**
     * Registra uma nova candidatura
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request){
        $candidatura = $this->validate($request, Candidatura::$rules);
        $candidatura['codStatusCandidatura'] = STATUS_ANALISE;
        Candidatura::create($candidatura);
    }

    /**
     * Exclui uma candidatura
     *
     * @param int $codCandidatura
     */
    public function destroy(int $codCandidatura){
        Candidatura::destroy($codCandidatura);
    }

    /**
     * Troca o status de uma candidatura
     *
     * @param Request $request
     * @param $codCandidatura
     */
    public function trocarStatus(Request $request, $codCandidatura){
        $candidatura = Candidatura::findOrFail($codCandidatura);
        $candidatura['codStatusCandidatura'] = $request->codStatusCandidatura;
        $candidatura->save();
    }
}
