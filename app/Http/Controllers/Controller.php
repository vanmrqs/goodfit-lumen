<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Laravel\Lumen\Routing\Controller as BaseController;

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
        $imagem = app()->basePath('public/images/'.$pastaOrigem.'/' . $imagem);

        if ( file_exists($imagem) ) {
            unlink($imagem);
        }
    }
}
