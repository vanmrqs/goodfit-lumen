<?php


namespace App\Http\Controllers;


use App\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VagaController extends Controller {
    public function index(){
        return Vaga::all();
    }

    public function show(int $codVaga){
        return Vaga::find($codVaga);
    }

    public function store(Request $request){
        $vaga = $this->validate($request, Vaga::$rules);
        Vaga::create($vaga);
    }

    public function update(Request $request, int $codVaga){
        $this->validate($request, Vaga::$rules);

        $vaga = Vaga::findOrFail($codVaga);
        $vaga['descricaoVaga']        = $request->descricaoVaga;
        $vaga['salarioVaga']          = $request->salarioVaga;
        $vaga['cargaHorariaVaga']     = $request->cargaHorariaVaga;
        $vaga['quantidadeVaga']       = $request->quantidadeVaga;
        $vaga['codProfissao']         = $request->codProfissao;
        $vaga['codEmpresa']           = $request->codEmpresa;
        $vaga['codEndereco']          = $request->codEndereco;
        $vaga['codRegimeContratacao'] = $request->codRegimeContratacao;
        $vaga->save();
    }

    public function destroy(int $codVaga){
        Vaga::destroy($codVaga);
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
}
