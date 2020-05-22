<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Adicional;
use App\Curriculo;

class AdicionalCurriculo extends Model
{
    protected $table 	  = 'tbAdicionalCurriculo';
    protected $primaryKey = 'codAdicionalCurriculo';
    protected $fillable   = ['codAdicional', 'codCurriculo'];

    public static $rules  = [
        'codAdicional' => 'integer|required',
        'codCurriculo' => 'integer|required'
    ];

    public function Adicional(){
    	return $this->hasOne(Adicional::class, 'codAdicional', 'codAdicional');
    }

    public function Curriculo(){
    	return $this->belongsTo(Curriculo::class, 'codCurriculo', 'codCurriculo');
    }
}
