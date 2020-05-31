<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
	protected $table      = 'tbEndereco';
	protected $primaryKey = 'codEndereco';
	protected $fillable   =
	['cepEndereco', 'logradouroEndereco', 'numeroEndereco', 'complementoEndereco', 'bairroEndereco', 'zonaEndereco', 'cidadeEndereco', 'estadoEndereco'];

    public static $rules  = [
        'cepEndereco'         => 'string|required|min:8|max:8',
        'logradouroEndereco'  => 'string|min:6|max:200',
        'numeroEndereco'      => 'string|required|max:5',
        'complementoEndereco' => 'string',
        'bairroEndereco'      => 'string|required|min:6|max:50',
        'zonaEndereco'        => 'string|required|min:3|max:50',
        'cidadeEndereco'      => 'string|required|min:3|max:100',
        'estadoEndereco'      => 'string|required|min:2|max:50'
    ];
}
