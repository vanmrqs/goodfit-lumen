<?php


namespace App\Http\Controllers;


use App\Candidatura;
use App\Empresa;
use App\Http\Helper\EmpresaHelper;
use App\Http\Helper\VagaHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

define('STATUS_APROVADO', 1);
define('STATUS_ANALISE', 2);
define('STATUS_RECUSADO', 3);
define('STATUS_PROCESSO', 4);

define('STATUS_CANDIDATURA', [
    STATUS_APROVADO,
    STATUS_ANALISE,
    STATUS_RECUSADO,
    STATUS_PROCESSO
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

        $vaga = VagaHelper::getVagaPorCandidatura($candidatura);

        if (
            (! $request->codStatus === STATUS_RECUSADO)
            && ((int)$vaga->getAttribute('quantidadeDisponivelVaga') <= 0)
        ) {
            return response()->json([
                'error' => 'Vaga indisponível'
            ], 400);
        }

        DB::beginTransaction();

        $candidatura['codStatusCandidatura'] = $request->codStatus;
        $candidatura['feedbackCandidatura']  = $response->feedback;
        $candidatura->save();

        if ( $request->codStatus === STATUS_APROVADO ) {
            $vaga->setAttribute('quantidadeDisponivelVaga', (int)$vaga->getAttribute('quantidadeDisponivelVaga') - 1);
            $vaga->save();
        }

        DB::commit();

        return response()->json([
            'message' => 'success',
            'status'  => 200
        ], 200);
    }

    /**
     * Retorna a compatibilidade de um candidato com
     * uma vaga
     *
     * @param Request $request
     * @return mixed
     */
    public function getCompatibilidade(Request $request) {
        return DB::select("
            SELECT
                ROUND((SUM(possui) / SUM(total)) * 100, 0) AS 'compatibilidade'
            FROM (
                SELECT
                    SUM(IF(tbAdicionalCurriculo.codAdicionalCurriculo IS NOT NULL, 1, 0)) AS 'possui',
                    COUNT(tbRequisitoVaga.codRequisitoVaga) AS 'total'
                FROM tbVaga
                INNER JOIN tbRequisitoVaga
                    ON tbVaga.codVaga = tbRequisitoVaga.codVaga
                INNER JOIN tbAdicional
                    ON tbRequisitoVaga.codAdicional = tbAdicional.codAdicional
                    AND tbAdicional.codTipoAdicional = 1
                INNER JOIN tbCandidatura
                    ON tbVaga.codVaga = tbcandidatura.codVaga
                INNER JOIN tbCandidato
                    ON tbcandidatura.codCandidato = tbCandidato.codCandidato
                INNER JOIN tbCurriculo
                    ON tbCandidato.codCandidato = tbCurriculo.codCurriculo
                LEFT JOIN tbAdicionalCurriculo
                    ON tbAdicional.codAdicional = tbAdicionalCurriculo.codAdicional
                WHERE tbVaga.codVaga = ".$request->codVaga."
                    AND tbCandidatura.codCandidato = ".$request->codCandidato."

                UNION

                SELECT
                    SUM(IF(tbCargoCurriculo.codCargoCurriculo IS NOT NULL, 1, 0)) AS 'possui',
                    COUNT(tbVaga.codProfissao) AS 'total'
                FROM tbVaga
                INNER JOIN tbProfissao
                    ON tbVaga.codProfissao = tbProfissao.codProfissao
                INNER JOIN tbCategoria
                    ON tbProfissao.codCategoria = tbCategoria.codCategoria
                INNER JOIN tbCandidatura
                    ON tbVaga.codVaga = tbcandidatura.codVaga
                INNER JOIN tbCandidato
                    ON tbcandidatura.codCandidato = tbCandidato.codCandidato
                INNER JOIN tbCurriculo
                    ON tbCandidato.codCandidato = tbCurriculo.codCurriculo
                LEFT JOIN tbCargoCurriculo
                    ON tbCategoria.codCategoria = tbCargoCurriculo.codCategoria
                WHERE tbVaga.codVaga = ".$request->codVaga."
                    AND tbCandidatura.codCandidato = ".$request->codCandidato."

                UNION

                SELECT
                    SUM(IF(adicionalCandidato.codAdicional IS NOT NULL, 1, 0)) AS 'possui',
                    COUNT(tbRequisitoVaga.codAdicional) AS 'total'
                FROM tbVaga
                INNER JOIN tbRequisitoVaga
                    ON tbVaga.codVaga = tbRequisitoVaga.codVaga
                INNER JOIN tbAdicional AS adicionalVaga
                    ON tbRequisitoVaga.codAdicional = adicionalVaga.codAdicional
                INNER JOIN tbTipoAdicional AS tipoVaga
                    ON adicionalVaga.codTipoAdicional = tipoVaga.codTipoAdicional
                    AND tipoVaga.escalonavelTipoAdicional = 1
                INNER JOIN tbCandidatura
                    ON tbVaga.codVaga = tbCandidatura.codVaga
                    AND tbCandidatura.codCandidato = 1
                INNER JOIN tbCandidato
                    ON tbcandidatura.codCandidato = tbCandidato.codCandidato
                INNER JOIN tbCurriculo
                    ON tbCandidato.codCandidato = tbCurriculo.codCurriculo
                INNER JOIN tbAdicionalCurriculo
                    ON tbCurriculo.codCurriculo = tbAdicionalCurriculo.codCurriculo
                INNER JOIN tbAdicional AS adicionalCandidato
                    ON tbAdicionalCurriculo.codAdicional = adicionalCandidato.codAdicional
                    AND adicionalVaga.codTipoAdicional = adicionalCandidato.codTipoAdicional
                    AND adicionalCandidato.grauAdicional >= adicionalVaga.grauAdicional
                WHERE tbVaga.codVaga = ".$request->codVaga."
                    AND tbCandidatura.codCandidato = ".$request->codCandidato."
            ) AS compatibilidade");
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
