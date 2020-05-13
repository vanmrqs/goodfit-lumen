<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Candidato;

class Curriculo extends Model
{
    protected $table      = 'tbCurriculo';
    protected $primaryKey = 'codCurriculo';
    protected $fillable   = ['videoCurriculo', 'descricaoCurriculo', 'codCandidato'];

    public static $rules  = [
        'videoCurriculo'     => 'string',
        'descricaoCurriculo' => 'string',
        'codCandidato'       => 'integer|required'
    ];

    public function Candidato(){
    	return $this->belongsTo(Candidato::class, 'codCandidato', 'codCandidato');
    }
}
