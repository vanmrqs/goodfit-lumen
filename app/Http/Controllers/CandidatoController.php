<?php


namespace App\Http\Controllers;


use App\Candidato;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CandidatoController extends Controller {
    /**
     * Retorna todos os candidatos
     * cadastrados
     *
     * @return Candidato[]|Collection
     */
    public function index(){
        return Candidato::all();
    }

    /**
     * Retorna um candidato pelo
     * código
     *
     * @param int $codCandidato
     * @return mixed
     */
    public function show(int $codCandidato){
        return Candidato::find($codCandidato);
    }

    /**
     * Cadastra um novo candidato
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $candidato = $this->validate($request, Candidato::$rules);

        $candidato['cpfCandidato'] = $this->removeNaoNumericos($candidato['cpfCandidato']);
        if ( ! $this->validaCPF($candidato['cpfCandidato']) ) {
            return response()->json(['message' => 'CPF inválido'], 400);
        }

        Candidato::create($candidato);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Atualiza um candidato
     *
     * @param Request $request
     * @param $codCandidato
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $codCandidato){
        $this->validate($request, Candidato::$rules);

        $request->cpfCandidato = $this->removeNaoNumericos($request->cpfCandidato);
        if ( ! $this->validaCPF($request->cpfCandidato) ) {
            return response()->json(['message' => 'CPF inválido'], 400);
        }

        $candidato = Candidato::findOrFail($codCandidato);
        $candidato->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui um candidato
     *
     * @param int $codCandidato
     * @return JsonResponse
     */
    public function destroy(int $codCandidato){
        // TODO: Excluir usuário
        Candidato::destroy($codCandidato);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Retorna um candidato pelo
     * código do usuário
     *
     * @param int $codUsuario
     * @return mixed
     */
    public function getPorUsuario(int $codUsuario){
        return Candidato::where('codUsuario', $codUsuario)->get();
    }

    /**
     * Devolve apenas os números do
     * texto passado
     *
     * @param string $texto
     * @return string|string[]|null
     * @author Vanessa Amaral Marques
     */
    private function removeNaoNumericos(string $texto){
        return preg_replace('/[^0-9]/', '', $texto);
    }

    /**
     * Retorna se um cpf é válido
     *
     * @param string $cpf
     * @return bool
     */
    private function validaCPF(string $cpf) {
        if ( strlen($cpf) != 11 ) {
            return false;
        }

        if ( preg_match('/(\d)\1{10}/', $cpf) ) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}
