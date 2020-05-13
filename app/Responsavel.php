<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Candidato;

class Responsavel extends Model
{
    protected $table 	  = 'tbResponsavel';
    protected $primaryKey = 'codResponsavel';
    protected $fillable   = ['nomeResponsavel', 'codCandidato'];

    public static $rules  = [
        'nomeResponsavel' => 'string|required|min:6|max:150',
        'codCandidato'    => 'integer|required'
    ];

    public function Candidato(){
      return $this->belongsTo(Candidato::class, 'codCandidato', 'codCandidato');
    }
}
