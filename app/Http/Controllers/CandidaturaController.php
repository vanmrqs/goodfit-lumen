<?php


namespace App\Http\Controllers;


use App\Candidatura;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $candidatura = $this->validate($request, Candidatura::$rules);
        $candidatura['codStatusCandidatura'] = STATUS_ANALISE;
        Candidatura::create($candidatura);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui uma candidatura
     *
     * @param int $codCandidatura
     * @return JsonResponse
     */
    public function destroy(int $codCandidatura){
        Candidatura::destroy($codCandidatura);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Troca o status de uma candidatura
     *
     * @param Request $request
     * @param $codCandidatura
     * @return JsonResponse
     */
    public function trocarStatus(Request $request, $codCandidatura){
        $candidatura = Candidatura::findOrFail($codCandidatura);
        $candidatura['codStatusCandidatura'] = $request->codStatusCandidatura;
        $candidatura->save();
        return response()->json(['message' => 'success'], 200);
    }
}
