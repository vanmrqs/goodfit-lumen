<?php


namespace App\Http\Controllers;

use App\ExperienciaProfissional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

define('PASTA_UPLOADS', 'experiencia');

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
        if ( $request->has('videoExperienciaProfissionalArquivo') ) {
            $request['videoExperienciaProfissional'] = $this->uploadVideo($request->videoExperienciaProfissionalArquivo, PASTA_UPLOADS);
        }

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

        if ( $request->has('videoExperienciaProfissionalArquivo') ) {
            $this->deletaVideo($experiencia['videoExperienciaProfissional'], PASTA_UPLOADS);
            $request['videoExperienciaProfissional'] = $this->uploadVideo($request->videoExperienciaProfissionalArquivo, PASTA_UPLOADS);
        }

        $experiencia->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Retorna as experiências profissionais
     * pelo currículo
     *
     * @param Request $request
     * @return mixed
     */
    public function getPorCurriculo(Request $request){
        return ExperienciaProfissional::where('tbExperienciaProfissional.codCurriculo', $request->codCurriculo)
            ->orderBy('tbExperienciaProfissional.dataInicioExperienciaProfissional')
            ->get();
    }

    /**
     * Retorna as experiências profissionais
     * pelo candidato
     *
     * @param Request $request
     * @return mixed
     */
    public function getPorCandidato(Request $request){
        return ExperienciaProfissional::join('tbCurriculo', 'tbExperienciaProfissional.codCurriculo', 'tbCurriculo.codCurriculo')
            ->join('tbCandidato', 'tbCurriculo.codCandidato', 'tbCandidato.codCandidato')
            ->join('tbProfissao', 'tbExperienciaProfissional.codProfissao', 'tbProfissao.codProfissao')
            ->join('tbCategoria', 'tbProfissao.codCategoria', 'tbCategoria.codCategoria')
            ->where('tbCandidato.codCandidato', $request->codCandidato)
            ->select(
                'tbExperienciaProfissional.empresaExperienciaProfissional',
                'tbExperienciaProfissional.descricaoExperienciaProfissional',
                'tbExperienciaProfissional.dataInicioExperienciaProfissional',
                'tbExperienciaProfissional.dataFinalExperienciaProfissional',
                'tbExperienciaProfissional.isEmpregoAtualExperienciaProfissional',
                'tbProfissao.nomeProfissao',
                'tbCategoria.imagemCategoria'
            )
            ->orderBy('tbExperienciaProfissional.dataInicioExperienciaProfissional')
            ->get();
    }
}
