<?php


namespace App\Http\Controllers;


use App\StatusCandidatura;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StatusController extends Controller {
    /**
     * Retorna todos os status
     * cadastrados
     *
     * @return StatusCandidatura[]|Collection
     */
    public function index(){
        return StatusCandidatura::all();
    }

    /**
     * Retorna um status pelo código
     *
     * @param int $codStatus
     * @return mixed
     */
    public function show(int $codStatus){
        return StatusCandidatura::find($codStatus);
    }

    /**
     * Cria um novo status
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request){
        $status = $this->validate($request, StatusCandidatura::$rules);
        StatusCandidatura::create($status);
    }

    /**
     * Atualiza um status
     *
     * @param Request $request
     * @param int $codStatus
     * @throws ValidationException
     */
    public function update(Request $request, int $codStatus){
        $this->validate($request, StatusCandidatura::$rules);

        $status = StatusCandidatura::findOrFail($codStatus);
        $status['nomeStatusCandidatura'] = $request->nomeStatusCandidatura;
        $status->save();
    }

    /**
     * Retorna o status de uma candidatura
     *
     * @param int $codCandidatura
     * @return mixed
     */
    public function getPorCandidatura(int $codCandidatura){
        return StatusCandidatura::join('tbCandidatura', 'tbStatusCandidatura.codStatusCandidatura', '=', 'tbCandidatura.codStatusCandidatura')
            ->where('tbCandidatura.codCandidatura', $codCandidatura)
            ->get();
    }
}
