<?php

namespace App\Http\Helper;

use App\Empresa;
use App\Usuario;
use App\Vaga;

class EmpresaHelper {
    /**
     * Retorna se a empresa é dona da vaga
     *
     * @param Empresa $empresa
     * @param int $codVaga
     * @return bool
     */
    public static function isEmpresaDonaDaVaga(Empresa $empresa, int $codVaga) {
        $vaga = Vaga::findOrFail($codVaga);

        return ($vaga->getAttribute('codEmpresa') === $empresa->getAttribute('codEmpresa'));
    }

    public static function validaEmpresa(Usuario $usuario) {
        if ( ! UsuarioHelper::isSpecialUser($usuario) ) {
            return response()->json([
                'error' => 'Você não possui permissão para acessar esses dados'
            ], 403);
        }

        return UsuarioHelper::getEmpresaPorUsuario($usuario);
    }
}
