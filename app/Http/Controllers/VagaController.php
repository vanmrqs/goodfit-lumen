<?php


namespace App\Http\Controllers;


use App\Http\Helper\EmpresaHelper;
use App\Http\Helper\UsuarioHelper;
use App\Vaga;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VagaController extends Controller {
    /**
     * Retorna todas as vagas
     * cadastradas
     *
     * @return Vaga[]|Collection
     */
    public function index(){
        return Vaga::all();
    }

    /**
     * Retorna uma vaga específica
     * pelo código
     *
     * @param int $codVaga
     * @return mixed
     */
    public function show(int $codVaga){
        return Vaga::find($codVaga);
    }

    /**
     * Cria uma nova vaga
     *
     * @param Request $request
     * @return int
     * @throws ValidationException
     */
    public function store(Request $request){
        $vaga = $this->validate($request, Vaga::$rules);
        $vaga = Vaga::create($vaga);
        return $vaga->codVaga;
    }

    /**
     * Atualiza uma vaga
     *
     * @param Request $request
     * @param int $codVaga
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $codVaga){
        $this->validate($request, Vaga::$rules);

        $vaga = Vaga::findOrFail($codVaga);
        $vaga->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui uma vaga pelo código
     *
     * @param int $codVaga
     * @return JsonResponse
     */
    public function destroy(int $codVaga){
        Vaga::destroy($codVaga);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Realiza o match de vaga com candidato
     * e retorna as vagas compatíveis
     *
     * @param int $codCandidato
     * @param int $codCurriculo
     * @return array
     */
    public function getMatch(int $codCandidato, int $codCurriculo){
        $vagas = DB::select("
        SELECT
            tbVaga.codVaga,
            tbVaga.descricaoVaga,
            tbVaga.salarioVaga,
            tbVaga.cargaHorariaVaga,
            tbVaga.quantidadeVaga,
            tbEmpresa.codEmpresa,
            tbEmpresa.nomeFantasiaEmpresa,
            tbProfissao.nomeProfissao,
            tbEndereco.cepEndereco,
            tbEndereco.logradouroEndereco,
            tbEndereco.complementoEndereco,
            tbEndereco.numeroEndereco,
            tbEndereco.bairroEndereco,
            tbEndereco.zonaEndereco,
            tbEndereco.cidadeEndereco,
            tbEndereco.estadoEndereco,
            tbRegimeContratacao.nomeRegimeContratacao
        FROM tbVaga
        INNER JOIN tbEmpresa
            ON tbVaga.codEmpresa = tbEmpresa.codEmpresa
        INNER JOIN tbProfissao
            ON tbVaga.codProfissao = tbProfissao.codProfissao
        INNER JOIN tbEndereco
            ON tbVaga.codEndereco = tbEndereco.codEndereco
        INNER JOIN tbRegimeContratacao
            ON tbVaga.codRegimeContratacao = tbRegimeContratacao.codRegimeContratacao
        INNER JOIN tbRequisitoVaga
            ON tbVaga.codVaga = tbRequisitoVaga.codVaga
        INNER JOIN tbCategoria
            ON tbProfissao.codCategoria = tbCategoria.codCategoria
        INNER JOIN tbCargoCurriculo
            ON tbCategoria.codCategoria = tbCargoCurriculo.codCategoria
            AND tbCargoCurriculo.codCurriculo = ".$codCurriculo."
        LEFT JOIN tbCandidatura
            ON tbvaga.codVaga = tbCandidatura.codVaga
            AND tbCandidatura.codCandidato = 1
        INNER JOIN tbAdicional AS tbComparaVaga
            ON tbRequisitoVaga.codAdicional = tbComparaVaga.codAdicional
            AND tbComparaVaga.codTipoAdicional IN (2, 3)
        INNER JOIN tbAdicionalCurriculo
            ON tbAdicionalCurriculo.codCurriculo = ".$codCurriculo."
        INNER JOIN tbAdicional AS tbComparaCurriculo
            ON tbAdicionalCurriculo.codAdicional = tbComparaCurriculo.codAdicional
            AND tbComparaCurriculo.codTipoAdicional IN (2, 3)
        INNER JOIN tbCandidato
            ON tbCandidato.codCandidato = ".$codCandidato."
        LEFT JOIN tbAdicionalCurriculo AS tbOpcionais
            ON tbRequisitoVaga.codAdicional = tbOpcionais.codAdicional
            AND tbOpcionais.codCurriculo = ".$codCurriculo."
        WHERE tbCandidatura.codCandidatura IS NULL
	        AND tbComparaVaga.codTipoAdicional = tbComparaCurriculo.codTipoAdicional
            AND tbComparaCurriculo.grauAdicional >= tbComparaVaga.grauAdicional
            AND tbVaga.codVaga NOT IN (
                SELECT tbVaga.codVaga
                FROM tbVaga
                INNER JOIN tbRequisitoVaga
                    ON tbVaga.codVaga = tbRequisitoVaga.codVaga
                INNER JOIN tbAdicional
                    ON tbRequisitovaga.codAdicional = tbAdicional.codAdicional
                WHERE tbRequisitoVaga.codAdicional NOT IN (
                    SELECT tbAdicionalCurriculo.codAdicional
                    FROM tbAdicionalCurriculo
                    WHERE tbAdicionalCurriculo.codCurriculo = ".$codCurriculo."
                ) AND tbRequisitoVaga.obrigatoriedadeRequisitoVaga = 1
                AND tbAdicional.codTipoAdicional = 1
            ) AND (
                (
                    TIMESTAMPDIFF(YEAR, FROM_UNIXTIME(tbCandidato.dataNascimentoCandidato), FROM_UNIXTIME(UNIX_TIMESTAMP())) <= 16
                    AND tbRegimeContratacao.nomeRegimeContratacao LIKE 'Estagiário'
                ) OR (
                    TIMESTAMPDIFF(YEAR, FROM_UNIXTIME(tbCandidato.dataNascimentoCandidato), FROM_UNIXTIME(UNIX_TIMESTAMP())) > 16
                )
            )
        GROUP BY
            tbVaga.codVaga,
            tbVaga.descricaoVaga,
            tbVaga.salarioVaga,
            tbVaga.cargaHorariaVaga,
            tbVaga.quantidadeVaga,
            tbEmpresa.codEmpresa,
            tbEmpresa.nomeFantasiaEmpresa,
            tbProfissao.nomeProfissao,
            tbEndereco.cepEndereco,
            tbEndereco.logradouroEndereco,
            tbEndereco.complementoEndereco,
            tbEndereco.numeroEndereco,
            tbEndereco.bairroEndereco,
            tbEndereco.zonaEndereco,
            tbEndereco.cidadeEndereco,
            tbEndereco.estadoEndereco,
            tbRegimeContratacao.nomeRegimeContratacao");

        return $vagas;
    }

    /**
     * Retorna as vagas de uma empresa
     *
     * @param int $codEmpresa
     * @return mixed
     */
    public function getPorEmpresa(Request $request){
        $usuario = $request->auth;

        if ( ! UsuarioHelper::isSpecialUser($usuario) ) {
            return response()->json([
                'error' => 'Você não possui permissão para acessar esses dados'
            ], 403);
        }

        $empresa = UsuarioHelper::getEmpresaPorUsuario($usuario);

        return Vaga::where('codEmpresa', $empresa->getAttribute('codEmpresa'))->paginate(5);
    }

    public function getVaga(Request $request) {
        $usuario = $request->auth;

        if ( ! UsuarioHelper::isSpecialUser($usuario) ) {
            return response()->json([
                'error' => 'Você não possui permissão para acessar esses dados'
            ], 403);
        }

        $empresa = UsuarioHelper::getEmpresaPorUsuario($usuario);

        if ( ! EmpresaHelper::isEmpresaDonaDaVaga($empresa, $request->codVaga) ) {
            return response()->json([
                'error' => 'Você não possui permissão para visualizar esta vaga'
            ], 403);
        }

        return $this->getVagaAllInfo($request->codVaga);
    }

    /**
     * Retorna uma vaga pelo código
     * com suas informações
     *
     * @param int $codVaga
     * @return array
     */
    private function getVagaAllInfo(int $codVaga) {
        return DB::select("
        SELECT
            tbVaga.descricaoVaga,
            tbVaga.salarioVaga,
            tbVaga.cargaHorariaVaga,
            tbVaga.quantidadeVaga,
            tbProfissao.nomeProfissao,
            tbCategoria.imagemCategoria,
            CONCAT(
                tbEndereco.logradouroEndereco, ', ',
                tbEndereco.numeroEndereco, 	   ' - ',
                tbEndereco.bairroEndereco
            ) AS 'endereco',
            tbRegimeContratacao.nomeRegimeContratacao
        FROM tbVaga
        INNER JOIN tbProfissao
            ON tbVaga.codProfissao = tbProfissao.codProfissao
        INNER JOIN tbCategoria
            ON tbProfissao.codCategoria = tbCategoria.codCategoria
        INNER JOIN tbEndereco
            ON tbVaga.codEndereco = tbEndereco.codEndereco
        INNER JOIN tbRegimeContratacao
            ON tbVaga.codRegimeContratacao = tbRegimeContratacao.codRegimeContratacao
        WHERE tbVaga.codVaga = ".$codVaga);
    }
}
