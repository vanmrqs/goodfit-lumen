<?php


namespace App\Http\Controllers;


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
            COUNT(tbAdicionalCurriculo.codAdicional) AS 'Habilidades',
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
        INNER JOIN tbAdicionalCurriculo
            ON tbRequisitoVaga.codAdicional = tbAdicionalCurriculo.codAdicional
        INNER JOIN tbCategoria
            ON tbProfissao.codCategoria = tbCategoria.codCategoria
        INNER JOIN tbCargoCurriculo
            ON tbCategoria.codCategoria = tbCargoCurriculo.codCategoria
        WHERE tbVaga.codVaga NOT IN (
            SELECT tbCandidatura.codVaga
            FROM tbCandidatura
            WHERE tbCandidatura.codCandidato = '$codCandidato'
        )
        AND tbVaga.codVaga NOT IN (
            SELECT tbVaga.codVaga
            FROM tbVaga
            INNER JOIN tbRequisitoVaga
                ON tbVaga.codVaga = tbRequisitoVaga.codVaga
            WHERE tbRequisitoVaga.codAdicional NOT IN (
                SELECT tbAdicionalCurriculo.codAdicional
                FROM tbAdicionalCurriculo
                WHERE tbAdicionalCurriculo.codCurriculo = '$codCurriculo'
            ) AND tbRequisitoVaga.obrigatoriedadeRequisitoVaga = 1
        ) AND tbVaga.codVaga IN (
            SELECT tbVaga.codVaga
            FROM tbVaga
            INNER JOIN tbRequisitoVaga
                ON tbVaga.codVaga = tbRequisitoVaga.codVaga
            INNER JOIN tbAdicionalCurriculo
                ON tbRequisitoVaga.codAdicional = tbAdicionalCurriculo.codAdicional
        )
        AND tbVaga.quantidadeVaga > 0
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
            tbRegimeContratacao.nomeRegimeContratacao
        ORDER BY Habilidades DESC");

        return $vagas;
    }

    /**
     * Retorna as vagas de uma empresa
     *
     * @param int $codEmpresa
     * @return mixed
     */
    public function getPorEmpresa(int $codEmpresa){
        return Vaga::where('codEmpresa', $codEmpresa)->paginate(5);
    }
}
