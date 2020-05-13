<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Categoria;

class Profissao extends Model
{
    protected $table 	  = 'tbProfissao';
    protected $primaryKey = 'codProfissao';
    protected $fillable   = ['nomeProfissao', 'codCategoria'];

    public static $rules  = [
        'nomeProfissao' => 'string|required|min:3|max:100',
        'codCategoria'  => 'integer|required'
    ];

    public function Categoria(){
      return $this->belongsTo(Categoria::class, 'codCategoria', 'codCategoria');
    }
}
