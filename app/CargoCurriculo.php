<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profissao;
use App\Curriculo;

class CargoCurriculo extends Model
{
  protected $table 		= 'tbCargoCurriculo';
  protected $primaryKey = 'codCargoCurriculo';
  protected $fillable 	= ['codCategoria', 'codCurriculo'];

  public static $rules  = [
      'codCategoria' => 'integer|required',
      'codCurriculo' => 'integer|required'
  ];

  public function Cargo(){
    return $this->hasOne(Profissao::class, 'codProfissao', 'codProfissao');
  }

  public function Curriculo(){
    return $this->belongsTo(Curriculo::class, 'codCurriculo', 'codCurriculo');
  }
}
