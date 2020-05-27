<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adicional extends Model
{
    protected $table	  = 'tbAdicional';
    protected $primaryKey = 'codAdicional';
    protected $fillable   = ['imagemAdicional', 'nomeAdicional', 'grauAdicional', 'codTipoAdicional'];

    public static $rules  = [
        'imagemAdicional'  => '',
        'nomeAdicional'    => 'required|max:100|string|unique:tbadicional',
        'grauAdicional'    => 'required|integer',
        'codTipoAdicional' => 'required|integer'
    ];

    public function TipoAdicional(){
    	return $this->hasOne(TipoAdicional::class, 'codAdicional', 'codAdicional');
    }
}
