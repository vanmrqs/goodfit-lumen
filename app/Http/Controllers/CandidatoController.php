<?php


namespace App\Http\Controllers;


use App\Candidato;
use Illuminate\Database\Eloquent\Collection;
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
     * @throws ValidationException
     */
    public function store(Request $request){
        $candidato = $this->validate($request, Candidato::$rules);

        // TODO: Verificar se CPF é valido
        $candidato['cpfCandidato'] = $this->removeNaoNumericos($candidato['cpfCandidato']);

        Candidato::create($candidato);
    }

    /**
     * Atualiza um candidato
     *
     * @param Request $request
     * @param $codCandidato
     * @throws ValidationException
     */
    public function update(Request $request, int $codCandidato){
        $this->validate($request, Candidato::$rules);

        //TODO: Verificar se cpf é válido
        $candidato = Candidato::findOrFail($codCandidato);
        $candidato['nomeCandidato']           = $request->nomeCandidato;
        $candidato['cpfCandidato']            = $this->removeNaoNumericos($request->cpfCandidato);
        $candidato['rgCandidato']             = $request->rgCandidato;
        $candidato['dataNascimentoCandidato'] = $request->dataNascimentoCandidato;
        $candidato->save();
    }

    /**
     * Exclui um candidato
     *
     * @param int $codCandidato
     */
    public function destroy(int $codCandidato){
        // TODO: Excluir usuário
        Candidato::destroy($codCandidato);
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
}
