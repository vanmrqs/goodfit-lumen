<?php

namespace App\Http\Helper;

use App\Empresa;
use App\Usuario;

define('NIVEL_MODERADOR', 1);
define('NIVEL_CANDIDATO', 2);
define('NIVEL_EMPRESA', 3);

class UsuarioHelper {
    public static function getEmpresaPorUsuario(Usuario $usuario) {
        return Empresa::where('codUsuario', $usuario->getAttribute('codUsuario'))->first();
    }

    public static function isSpecialUser(Usuario $usuario) {
        if ( in_array($usuario->getAttribute('codNivelUsuario'), [NIVEL_EMPRESA, NIVEL_MODERADOR]) ) {
            return true;
        }

        return false;
    }
}
