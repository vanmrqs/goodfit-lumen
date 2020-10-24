<?php


namespace App\Http\Controllers;


use App\Adicional;
use App\Http\Helper\EmpresaHelper;
use App\Http\Helper\UsuarioHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

define('PASTA_IMAGENS', 'adicional');

class AdicionalController extends Controller {
    /**
     * Retorna todos os adicionais
     * cadastrados no sistema
     *
     * @return Adicional[]|Collection
     */
    public function index(){
        return Adicional::all();
    }

    /**
     * Retorna um adicional específico
     *
     * @param int $codAdicional
     * @return mixed
     */
    public function show($codAdicional){
        return Adicional::find($codAdicional);
    }

    /**
     * Cria um novo adicional
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $adicional = $this->validate($request, Adicional::$rules);

        if ( $request->has('imagemAdicional') ) {
            $adicional['imagemAdicional'] = $this->uploadImagem($request->imagemAdicional, 300, 300, PASTA_IMAGENS);
        }

        Adicional::create($adicional);

        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Atualiza um adicional
     *
     * @param Request $request
     * @param int $codAdicional
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $codAdicional){
        $this->validate($request, Adicional::$rules);

        $adicional = Adicional::findOrFail($codAdicional);

        if ( $request->has('imagemAdicional') ) {
            $this->deletaImagem($adicional['imagemAdicional'], PASTA_IMAGENS);
            $adicional['imagemAdicional'] = $this->uploadImagem($request->imagemAdicional, 300, 300, PASTA_IMAGENS);
        }

        $adicional->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui um adicional
     *
     * @param int $codAdicional
     * @return JsonResponse
     */
    public function destroy($codAdicional){
        Adicional::destroy($codAdicional);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Retorna os adicionais pelo código
     * do tipo
     *
     * @param $codTipoAdicional
     * @return mixed
     */
    public function getPorTipo($codTipoAdicional){
        return Adicional::where('codTipoAdicional', $codTipoAdicional)->get();
    }

    /**
     * Retorna os adicionais pelo nome
     * do tipo
     *
     * @param $nomeTipoAdicional
     * @return mixed
     */
    public function getPorNomeTipo($nomeTipoAdicional){
        //TODO: Corrigir consultas com caracteres especiais

        return Adicional::join('tbTipoAdicional', 'tbAdicional.codTipoAdicional', '=', 'tbTipoAdicional.codTipoAdicional')
            ->where('tbTipoAdicional.nomeTipoAdicional', '=', $nomeTipoAdicional)
            ->get();
    }

    /**
     * Retorna os adicionais de um
     * currículo
     *
     * @param $codCurriculo
     * @return mixed
     */
    public function getEmCurriculo($codCurriculo){
        return Adicional::join('tbAdicionalCurriculo', 'tbAdicional.codAdicional', '=', 'tbAdicionalCurriculo.codAdicional')
            ->where('tbAdicionalCurriculo.codCurriculo', '=', $codCurriculo)
            ->get();
    }

    /**
     * Retorna as habilidades de um
     * currículo
     *
     * @param $codCurriculo
     * @return mixed
     */
    public function getHabilidadesCurriculo($codCurriculo){
        return Adicional::join('tbTipoAdicional', 'tbAdicional.codTipoAdicional', '=', 'tbTipoAdicional.codTipoAdicional')
            ->join('tbAdicionalCurriculo', 'tbAdicionalCurriculo.codAdicional', '=', 'tbAdicional.codAdicional')
            ->where('tbTipoAdicional.nomeTipoAdicional', '=', 'Habilidade')
            ->where('tbAdicionalCurriculo.codCurriculo', '=', $codCurriculo)
            ->orderBy('tbAdicional.nomeAdicional', 'ASC')
            ->get();
    }

    /**
     * Retorna os requisitos de uma vaga
     *
     * @param Request $request
     * @return mixed
     */
    public function getEmVaga(Request $request){
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

        return Adicional::join('tbRequisitoVaga', 'tbAdicional.codAdicional', 'tbRequisitoVaga.codAdicional')
            ->where('tbRequisitoVaga.codVaga', $request->codVaga)
            ->get();
    }
}
