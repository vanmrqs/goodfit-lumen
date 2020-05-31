<?php

namespace App\Http\Controllers;

use App\AdicionalCurriculo;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Laravel\Lumen\Routing\Controller as BaseController;

define('NIVEL_MODERADOR', 1);
define('NIVEL_CANDIDATO', 2);
define('NIVEL_EMPRESA', 3);

class Controller extends BaseController
{
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
    public function uploadImagem($imagem, $width, $height, $pastaDestino){
        $nomeImagem = md5(uniqid(microtime())).'.'.$imagem->getClientOriginalExtension();
        $caminho    = app()->basePath('public/images/'.$pastaDestino);

        if ( ! file_exists( $caminho ) ) {
            mkdir($caminho);
        }

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
    public function deletaImagem($imagem, $pastaOrigem){
        $imagem = app()->basePath('public/images/' . $pastaOrigem . '/' . $imagem);

        if ( file_exists($imagem) ) {
            unlink($imagem);
        }
    }

    /**
     * Realiza o upload de um vídeo
     * e retorna o nome dele
     *
     * @param $video
     * @param $pastaDestino
     * @return string
     */
    public function uploadVideo($video, $pastaDestino){
        $nomeVideo = md5(uniqid(microtime())).'.'.$video->getClientOriginalExtension();

        $video->move(app()->basePath('public/videos/'.$pastaDestino), $nomeVideo);

        return $nomeVideo;
    }

    /**
     * Apaga um vídeo existente
     *
     * @param $video
     * @param $pastaOrigem
     */
    public function deletaVideo($video, $pastaOrigem){
        $video = app()->basePath('public/videos/' . $pastaOrigem . '/' . $video);

        if ( file_exists($video) ) {
            unlink($video);
        }
    }

    /**
     * Cria itens em lote
     *
     * @param Request $request
     * @param string $nomeBase
     * @param string $nomeItens
     * @param string $nomeCampo
     * @param $objetoClasse
     */
    public function criaEmLote(Request $request, string $nomeBase, string $nomeItens, string $nomeCampo, $objetoClasse){
        $itemAdd = [];
        $itemAdd[$nomeBase] = $request->$nomeBase;
        foreach ( $request->$nomeItens as $item ) {
            $itemAdd[$nomeCampo] = $item;

            $classe = get_class($objetoClasse);
            $classe::create($itemAdd);
        }
    }

    /**
     * Remove itens em lote
     *
     * @param int $codBase
     * @param string $nomeBase
     * @param array $itens
     * @param string $nomeItem
     * @param $objetoClasse
     */
    public function removeEmLote(int $codBase, string $nomeBase, array $itens, string $nomeItem, $objetoClasse){
        $classe = get_class($objetoClasse);

        foreach ( $itens as $item ) {
            $itemRemover = $classe::where([
                [$nomeBase, $codBase],
                [$nomeItem, $item]
            ])->first();

            $primaryKey = $itemRemover->getKeyName();

            $classe::destroy($itemRemover->$primaryKey);
        }
    }
}
