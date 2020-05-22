<?php


namespace App\Http\Controllers;


use App\Endereco;
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
     * @throws ValidationException
     */
    public function store(Request $request){
        $endereco = $this->validate($request, Endereco::$rules);
        Endereco::create($endereco);
    }

    /**
     * Atualiza um endereço
     *
     * @param Request $request
     * @param int $codEndereco
     * @throws ValidationException
     */
    public function update(Request $request, int $codEndereco){
        $this->validate($request, Endereco::$rules);

        $endereco = Endereco::findOrFail($codEndereco);
        $endereco['cepEndereco']         = $request->cepEndereco;
        $endereco['logradouroEndereco']  = $request->logradouroEndereco;
        $endereco['numeroEndereco']      = $request->numeroEndereco;
        $endereco['complementoEndereco'] = $request->complementoEndereco;
        $endereco['bairroEndereco']      = $request->bairroEndereco;
        $endereco['zonaEndereco']        = $request->zonaEndereco;
        $endereco['cidadeEndereco']      = $request->cidadeEndereco;
        $endereco['estadoEndereco']      = $request->estadoEndereco;

        $endereco->save();
    }

    /**
     * Exclui um endereço pelo código
     *
     * @param int $codEndereco
     */
    public function destroy(int $codEndereco){
        Endereco::destroy($codEndereco);
    }
}
