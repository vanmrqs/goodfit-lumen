<?php

namespace App\Http\Helper;

use App\Candidato;
use App\Empresa;
use App\Usuario;
use Illuminate\Support\Facades\DB;

if ( ! defined('NIVEL_MODERADOR') ) {
    define('NIVEL_MODERADOR', 1);
}

if ( ! defined('NIVEL_CANDIDATO') ) {
    define('NIVEL_CANDIDATO', 2);
}

if ( ! defined('NIVEL_EMPRESA') ) {
    define('NIVEL_EMPRESA', 3);
}

class UsuarioHelper {
    public static function getEmpresaPorUsuario(Usuario $usuario) {
        return Empresa::where('codUsuario', $usuario->getAttribute('codUsuario'))->first();
    }

    public static function getCandidatoPorUsuario(Usuario $usuario) {
        return Candidato::where('codUsuario', $usuario->getAttribute('codUsuario'))->first();
    }

    public static function isSpecialUser(Usuario $usuario) {
        if ( in_array($usuario->getAttribute('codNivelUsuario'), [NIVEL_EMPRESA, NIVEL_MODERADOR]) ) {
            return true;
        }

        return false;
    }

    /**
     * Retorna o nome do usuário
     *
     * @param Usuario $usuario
     * @return mixed
     */
    public static function getNomeUsuario(Usuario $usuario) {
        return DB::select("
            SELECT
                CASE
                    WHEN tbAdministrador.nomeAdministrador IS NOT NULL THEN tbAdministrador.nomeAdministrador
                    WHEN tbEmpresa.nomeFantasiaEmpresa IS NOT NULL THEN tbEmpresa.nomeFantasiaEmpresa
                END AS 'nomeUsuario'
            FROM tbUsuario
            LEFT JOIN tbAdministrador
                ON tbUsuario.codUsuario = tbAdministrador.codUsuario
                AND tbUsuario.codNivelUsuario = 1
            LEFT JOIN tbEmpresa
                ON tbUsuario.codUsuario = tbEmpresa.codUsuario
                AND tbUsuario.codNivelUsuario = 3
            WHERE tbUsuario.codUsuario = ".$usuario->getAttribute('codUsuario'));
    }
}
