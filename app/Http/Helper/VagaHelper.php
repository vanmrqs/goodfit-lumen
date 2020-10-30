<?php

namespace App\Http\Helper;

use App\Candidatura;
use App\Vaga;

class VagaHelper {
    public static function getVagaPorCandidatura(Candidatura $candidatura) {
        return Vaga::where('codVaga', $candidatura->getAttribute('codVaga'))->first();
    }
    /**
     * Retorna se a vaga ainda possui
     * quantidades disponíveis
     *
     * @param Candidatura $candidatura
     * @return bool
     */
    public static function vagaPossuiQuantidadeDisponivel(Candidatura $candidatura) {
        $vaga = Vaga::where('codVaga', $candidatura->getAttribute('codVaga'));

        return ((int)$vaga->getAttribute('quantidadeDisponivelVaga') > 0);
    }
}
