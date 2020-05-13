<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Candidato;
use App\Vaga;

class Candidatura extends Model
{
  protected $table      = 'tbCandidatura';
  protected $primaryKey = 'codCandidatura';
  protected $fillable   =  ['codCandidato', 'codVaga', 'codStatusCandidatura'];

  public static $rules  = [
      'codCandidato'         => 'integer|required',
      'codVaga'              => 'integer|required',
      'codStatusCandidatura' => 'integer|required'
  ];

  public function Candidato(){
    return $this->hasMany(Candidato::class, 'codCandidato', 'codCandidato');
  }

  public function Vaga(){
    return $this->hasMany(Vaga::class, 'codVaga', 'codVaga');
  }
}
