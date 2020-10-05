<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Candidato;
use App\Vaga;

class Candidatura extends Model
{
  protected $table      = 'tbCandidatura';
  protected $primaryKey = 'codCandidatura';
  protected $fillable   =  ['codCandidato', 'codVaga', 'codStatusCandidatura', 'feedbackCandidatura'];

  public static $rules  = [
      'codCandidato'         => 'integer|required',
      'codVaga'              => 'integer|required',
      'codStatusCandidatura' => 'integer',
      'feedbackCandidatura'  => 'string|min:10'
  ];

  public function Candidato(){
    return $this->belongsTo(Candidato::class, 'codCandidato', 'codCandidato');
  }

  public function Vaga(){
    return $this->hasOne(Vaga::class, 'codVaga', 'codVaga');
  }
}
