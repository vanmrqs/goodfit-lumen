<?php


namespace App\Http\Controllers;

use App\ExperienciaProfissional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ExperienciaProfissionalController extends Controller {
    /**
     * Adiciona uma nova experiência profissional
     * em um currículo
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $experiencia = $this->validate($request, ExperienciaProfissional::$rules);
        ExperienciaProfissional::create($experiencia);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Atualiza uma experiência profissional
     *
     * @param Request $request
     * @param int $codExperiencia
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $codExperiencia){
        $this->validate($request, ExperienciaProfissional::$rules);

        $experiencia = ExperienciaProfissional::findOrFail($codExperiencia);
        $experiencia->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Retorna as experiências profissionais
     * pelo currículo
     *
     * @param int $codCurriculo
     * @return mixed
     */
    public function getPorUsuario(int $codCurriculo){
        return ExperienciaProfissional::where('tbExperienciaProfissional.codCurriculo', $codCurriculo)
            ->orderBy('tbExperienciaProfissional.dataInicioExperienciaProfissional')
            ->get();
    }
}
