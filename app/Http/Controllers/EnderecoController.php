<?php


namespace App\Http\Controllers;


use App\Endereco;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EnderecoController extends Controller {
    /**
     * Retorna um endereço pelo código
     *
     * @param int $codEndereco
     * @return mixed
     */
    public function show(int $codEndereco){
        return Endereco::find($codEndereco);
    }

    /**
     * Insere um novo endereço
     *
     * @param Request $request
     * @return int
     * @throws ValidationException
     */
    public function store(Request $request){
        $endereco = $this->validate($request, Endereco::$rules);
        $endereco = Endereco::create($endereco);
        return $endereco->codEndereco;
    }

    /**
     * Atualiza um endereço
     *
     * @param Request $request
     * @param int $codEndereco
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $codEndereco){
        $this->validate($request, Endereco::$rules);

        $endereco = Endereco::findOrFail($codEndereco);
        $endereco->update($request->all());
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Exclui um endereço pelo código
     *
     * @param int $codEndereco
     * @return JsonResponse
     */
    public function destroy(int $codEndereco){
        Endereco::destroy($codEndereco);
        return response()->json(['message' => 'success'], 200);
    }
}
