<?php


namespace App\Http\Controllers;


use App\Candidato;
use App\Http\Helper\UsuarioHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

define('PASTA_IMAGENS', 'candidato');

class CandidatoController extends Controller {
    /**
     * Retorna todos os candidatos
     * cadastrados
     *
     * @return Candidato[]|Collection
     */
    public function index(){
        return Candidato::all();
    }

    /**
     * Retorna um candidato pelo
     * código
     *
     * @param int $codCandidato
     * @return mixed
     */
    public function show(int $codCandidato){
        return Candidato::find($codCandidato);
    }

    /**
     * Cadastra um novo candidato
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $candidato = $this->validate($request, Candidato::$rules);

        $candidato['cpfCandidato'] = $this->removeNaoNumericos($candidato['cpfCandidato']);
        if ( ! $this->validaCPF($candidato['cpfCandidato']) ) {
            return response()->json(['message' => 'CPF inválido'], 400);
        }

        $candidato['imagemCpfCandidato'] = $this->uploadFoto($request->imagemCpf, $request->codNivelUsuario);

        Candidato::create($candidato);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Atualiza um candidato
     *
     * @param Request $request
     * @param $codCandidato
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $codCandidato){
        $this->validate($request, Candidato::$rules);

        $candidato = Candidato::findOrFail($codCandidato);

        $request->cpfCandidato = $this->removeNaoNumericos($request->cpfCandidato);
        if ( ! $this->validaCPF($request->cpfCandidato) ) {
            return response()->json(['message' => 'CPF inválido'], 400);
        }

        if ( $request->has('imagemCpf') ) {
            $this->deletaImagem($candidato['imagemCpfCandidato'], PASTA_IMAGENS);
            $request->fotoUsuario = $this->uploadFoto($request->imagemCpf);
        }

        $candidato->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui um candidato
     *
     * @param int $codCandidato
     * @return JsonResponse
     */
    public function destroy(int $codCandidato){
        // TODO: Excluir usuário
        Candidato::destroy($codCandidato);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Retorna um candidato pelo
     * código do usuário
     *
     * @param int $codUsuario
     * @return mixed
     */
    public function getPorUsuario(int $codUsuario){
        return Candidato::where('codUsuario', $codUsuario)->first();
    }

    /**
     * Retorna um candidato pelo código
     *
     * @param Request $request
     * @return array|JsonResponse
     */
    public function getCandidato(Request $request) {
        $usuario = $request->auth;

        if ( ($usuario->codUsuario !== $request->codCandidato) && ( ! UsuarioHelper::isSpecialUser($usuario) ) ) {
            return response()->json([
                'error' => 'Você não possui permissão para acessar esses dados'
            ], 403);
        }

        return DB::select("
            SELECT
                tbCandidato.nomeCandidato,
                tbUsuario.fotoUsuario,
                tbUsuario.email,
                tbCurriculo.videoCurriculo,
                tbCurriculo.descricaoCurriculo,
                TIMESTAMPDIFF(YEAR, FROM_UNIXTIME(tbCandidato.dataNascimentoCandidato), FROM_UNIXTIME(UNIX_TIMESTAMP())) AS 'idade'
            FROM tbCandidato
            INNER JOIN tbUsuario
                ON tbCandidato.codUsuario = tbUsuario.codUsuario
            INNER JOIN tbCurriculo
                ON tbCandidato.codCandidato = tbCurriculo.codCurriculo
            WHERE tbCandidato.codCandidato = ".$request->codCandidato);
    }

    /**
     * Retorna um candidato pelo código
     *
     * @param Request $request
     * @return array|JsonResponse
     */
    public function getCandidatoEmVaga(Request $request) {
        $usuario = $request->auth;

        return DB::select("
            SELECT
                tbCandidato.nomeCandidato,
                tbUsuario.fotoUsuario,
                tbUsuario.email,
                tbCurriculo.videoCurriculo,
                tbCurriculo.descricaoCurriculo,
                tbCandidatura.codStatusCandidatura,
                tbProfissao.codProfissao,
                tbCategoria.imagemCategoria,
                TIMESTAMPDIFF(YEAR, FROM_UNIXTIME(tbCandidato.dataNascimentoCandidato), FROM_UNIXTIME(UNIX_TIMESTAMP())) AS 'idade'
            FROM tbCandidato
            INNER JOIN tbUsuario
                ON tbCandidato.codUsuario = tbUsuario.codUsuario
            INNER JOIN tbCurriculo
                ON tbCandidato.codCandidato = tbCurriculo.codCurriculo
            INNER JOIN tbCandidatura
                ON tbCandidato.codCandidato = tbCandidatura.codCandidato
                AND tbCandidatura.codVaga = ".$request->codVaga."
            INNER JOIN tbVaga
                ON tbCandidatura.codVaga = tbVaga.codVaga
            INNER JOIN tbProfissao
                ON tbVaga.codProfissao = tbProfissao.codProfissao
            INNER JOIN tbCategoria
                ON tbProfissao.codCategoria = tbCategoria.codCategoria
            WHERE tbCandidato.codCandidato = ".$request->codCandidato);
    }

    /**
     * Retorna os candidatos que estão participando
     * de algum processo seletivo da empresa
     *
     * @param Request $request
     * @return mixed
     */
    public function getCandidatosPorEmpresa(Request $request){
        $usuario      = $request->auth;

        if ( ! UsuarioHelper::isSpecialUser($usuario) ) {
            return response()->json([
                'error' => 'Você não possui permissão para acessar esses dados'
            ], 403);
        }

        $empresa      = UsuarioHelper::getEmpresaPorUsuario($usuario);

        $candidaturas = Candidato::
            join('tbCandidatura', 'tbCandidato.codCandidato', 'tbCandidatura.codCandidato')
            ->join('tbVaga', 'tbCandidatura.codVaga', '=', 'tbVaga.codVaga')
            ->join('tbProfissao', 'tbProfissao.codProfissao', 'tbVaga.codProfissao')
            ->join('tbCategoria', 'tbProfissao.codCategoria', 'tbCategoria.codCategoria')
            ->join('tbUsuario', 'tbCandidato.codUsuario', 'tbUsuario.codUsuario')
            ->where('tbVaga.codEmpresa', $empresa->getAttribute('codUsuario'))
            ->select(
                'tbCandidatura.codCandidato',
                'tbProfissao.nomeProfissao',
                'tbCategoria.imagemCategoria',
                'tbVaga.codVaga',
                'tbVaga.descricaoVaga',
                'tbVaga.salarioVaga',
                'tbUsuario.fotoUsuario',
                'tbCandidato.nomeCandidato',
                'tbCandidatura.codStatusCandidatura'
            )
            ->paginate(15);


        return $this->separaCandidatosPorVaga($candidaturas);
    }

    /**
     * Retorna os candidatos em processo por empresa
     *
     * @param Request $request
     * @return array|JsonResponse
     */
    public function getEmProcessoPorEmpresa(Request $request) {
        $usuario      = $request->auth;

        if ( ! UsuarioHelper::isSpecialUser($usuario) ) {
            return response()->json([
                'error' => 'Você não possui permissão para acessar esses dados'
            ], 403);
        }

        $empresa      = UsuarioHelper::getEmpresaPorUsuario($usuario);

        $candidaturas = Candidato::join('tbCandidatura', 'tbCandidato.codCandidato', 'tbCandidatura.codCandidato')
            ->join('tbVaga', 'tbCandidatura.codVaga', '=', 'tbVaga.codVaga')
            ->join('tbProfissao', 'tbProfissao.codProfissao', 'tbVaga.codProfissao')
            ->join('tbCategoria', 'tbProfissao.codCategoria', 'tbCategoria.codCategoria')
            ->join('tbUsuario', 'tbCandidato.codUsuario', 'tbUsuario.codUsuario')
            ->where([
                ['tbVaga.codEmpresa', $empresa->getAttribute('codUsuario')],
                ['tbCandidatura.codStatusCandidatura', 4]
            ])
            ->select(
                'tbCandidatura.codCandidato',
                'tbProfissao.nomeProfissao',
                'tbCategoria.imagemCategoria',
                'tbVaga.codVaga',
                'tbVaga.descricaoVaga',
                'tbVaga.salarioVaga',
                'tbUsuario.fotoUsuario',
                'tbCandidato.nomeCandidato',
                'tbCandidatura.codStatusCandidatura'
            )
            ->paginate(15);

        return $this->separaCandidatosPorVaga($candidaturas);
    }

    /**
     * Devolve apenas os números do
     * texto passado
     *
     * @param string $texto
     * @return string|string[]|null
     * @author Vanessa Amaral Marques
     */
    private function removeNaoNumericos(string $texto){
        return preg_replace('/[^0-9]/', '', $texto);
    }

    /**
     * Separa as candidaturas por vaga
     *
     * @param Object $response
     * @return array
     */
    private function separaCandidatosPorVaga(Object $response) {
        $vagas = [];

        foreach ( $response->values() as $candidatura) {
            $codVaga = $candidatura->getAttribute('codVaga');

            if ( ! array_key_exists($codVaga, $vagas) ) {
                $vaga = new \stdClass();

                $vaga->codVaga         = $candidatura->getAttribute('codVaga');
                $vaga->descricaoVaga   = $candidatura->getAttribute('descricaoVaga');
                $vaga->imagemCategoria = $candidatura->getAttribute('imagemCategoria');
                $vaga->nomeProfissao   = $candidatura->getAttribute('nomeProfissao');
                $vaga->salarioVaga     = $candidatura->getAttribute('salarioVaga');
                $vaga->candidatos      = [];

                $vagas[$codVaga]       = $vaga;
            }

            unset($candidatura->codVaga);
            unset($candidatura->descricaoVaga);
            unset($candidatura->imagemCategoria);
            unset($candidatura->nomeProfissao);
            unset($candidatura->salarioVaga);

            $vagas[$codVaga]->candidatos[] = $candidatura;
        }

        return array_values($vagas);
    }

    /**
     * Retorna se um cpf é válido
     *
     * @param string $cpf
     * @return bool
     */
    private function validaCPF(string $cpf) {
        if ( strlen($cpf) != 11 ) {
            return false;
        }

        if ( preg_match('/(\d)\1{10}/', $cpf) ) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * Realiza o upload de foto para CPF
     *
     * @param $imagem
     * @return string
     */
    private function uploadFoto($imagem){
        if ( $imagem !== null ) {
            return $this->uploadImagem($imagem, 300, 300, PASTA_IMAGENS);
        }
    }
}
