<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Usuario;

class Candidato extends Model
{
    protected $table 	  = 'tbCandidato';
    protected $primaryKey = 'codCandidato';
    protected $fillable   = ['nomeCandidato', 'cpfCandidato', 'dataNascimentoCandidato', 'codUsuario'];

    public static $rules  = [
        'nomeCandidato'           => 'string|required|min:3|max:150',
        'cpfCandidato'            => 'string|required|min:11|max:11',
        'dataNascimentoCandidato' => 'integer|required',
        'codUsuario'              => 'integer|required'
    ];

    public function Usuario(){
    	return $this->hasOne(Usuario::class, 'codUsuario', 'codUsuario');
    }
}
