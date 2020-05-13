<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table 	  = 'tbCategoria';
    protected $primaryKey = 'codCategoria';
    protected $fillable   = ['nomeCategoria', 'imagemCategoria'];

    public static $rules  = [
        'nomeCategoria'   => 'string|required|min:2|max:100',
        'imagemCategoria' => 'string'
    ];

}
