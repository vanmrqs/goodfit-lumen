<?php

namespace App\Http\Helper;

use App\Empresa;
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
}
