<?php


namespace App\Http\Controllers;


use App\Adicional;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

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
        return Adicional::findOrFail($codAdicional);
    }

    /**
     * Cria um novo adicional
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request){
        $adicional = $this->validate($request, Adicional::$rules);

        if ( $request->has('imagemAdicional') ) {
            $adicional['imagemAdicional'] = $this->uploadImagem($request->imagemAdicional, 300, 300);
        }

        Adicional::create($adicional);
    }

    /**
     * Atualiza um adicional
     *
     * @param Request $request
     * @param int $codAdicional
     * @throws ValidationException
     */
    public function update(Request $request, $codAdicional){
        $this->validate($request, Adicional::$rules);

        $adicional = Adicional::findOrFail($codAdicional);

        if ( $request->has('imagemAdicional') ) {
            $this->deletaImagem($adicional['imagemAdicional']);
            $adicional['imagemAdicional'] = $this->uploadImagem($request->imagemAdicional, 300, 300);
        }

        $adicional['nomeAdicional']    = $request->nomeAdicional;
        $adicional['grauAdicional']    = $request->grauAdicional;
        $adicional['codTipoAdicional'] = $request->codTipoAdicional;
        $adicional->save();
    }

    /**
     * Exclui um adicional
     *
     * @param int $codAdicional
     */
    public function destroy($codAdicional){
        Adicional::findOrFail($codAdicional)->delete();
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
     * Realiza o upload de uma imagem e
     * retorna o nome dela
     *
     * @param $imagem
     * @param $pastaDestino
     * @param $width
     * @param $height
     * @return string
     */
    public function uploadImagem($imagem, $width, $height, $pastaDestino = PASTA_IMAGENS){
        $nomeImagem = md5(uniqid(microtime())).'.'.$imagem->getClientOriginalExtension();

        $image = Image::make($imagem);
        $image->orientate()->fit($width, $height);
        $image->save(app()->basePath('public/images/'.$pastaDestino.'/'.$nomeImagem));

        return $nomeImagem;
    }

    /**
     * Apaga uma imagem existente
     *
     * @param $imagem
     * @param string $pastaOrigem
     */
    public function deletaImagem($imagem, $pastaOrigem = PASTA_IMAGENS){
        $imagem = app()->basePath('public/images/'.$pastaOrigem.'/' . $imagem);

        if ( file_exists($imagem) ) {
            unlink($imagem);
        }
    }
}
