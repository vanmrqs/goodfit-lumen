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

  public function Categoria(){
    return $this->hasOne(Profissao::class, 'codCategoria', 'codCategoria');
  }

  public function Curriculo(){
    return $this->belongsTo(Curriculo::class, 'codCurriculo', 'codCurriculo');
  }
}
