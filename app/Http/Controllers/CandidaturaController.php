<?php


namespace App\Http\Controllers;


use App\Candidatura;
use App\Empresa;
use App\Http\Helper\EmpresaHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

define('STATUS_APROVADO', 1);
define('STATUS_ANALISE', 2);
define('STATUS_RECUSADO', 3);

define('STATUS_CANDIDATURA', [
   STATUS_APROVADO,
   STATUS_ANALISE,
   STATUS_RECUSADO
]);

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
     * @return JsonResponse
     */
    public function trocarStatus(Request $request){
        $usuario  = $request->auth;
        $response = EmpresaHelper::validaEmpresa($usuario);

        if ( ! $response instanceof Empresa ) return $response;

        $empresa     = $response;
        $candidatura = Candidatura::findOrFail($request->codCandidatura);

        if ( ! EmpresaHelper::isEmpresaDonaDaVaga($empresa, $candidatura->codVaga) ) {
            return response()->json([
                'error' => 'Você não possui permissão para alterar esta candidatura'
            ], 403);
        }

        if ( ! $this->isStatusValido($request->codStatus, $request->feedback) ) {
            return response()->json([
                'error' => 'Você não possui permissão para alterar esta candidatura'
            ], 400);
        }

        $candidatura['codStatusCandidatura'] = $request->codStatus;
        $candidatura['feedbackCandidatura']  = $response->feedback;
        $candidatura->save();

        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Retorna se o status de uma candidatura
     * é válido
     *
     * @param int $codStatus
     * @param string $feedback
     * @return bool
     */
    private function isStatusValido(int $codStatus, string $feedback) {
        if ( ! in_array($codStatus, STATUS_CANDIDATURA) ) {
            return false;
        }

        if ( ($codStatus === STATUS_RECUSADO) && (strlen($feedback)) === 0 ) {
            return false;
        }

        return true;
    }
}
