<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Usuario;

class Administrador extends Model
{
    protected $table 	  = 'tbAdministrador';
    protected $primaryKey = 'codAdministrador';
    protected $fillable   = ['nomeAdministrador', 'cpfAdministrador', 'unidadeAdministrador', 'codUsuario'];

    public static $rules  = [
        'nomeAdministrador'    => 'string|required|max:150',
        'cpfAdministrador'     => 'string|required|min:11|max:11',
        'unidadeAdministrador' => 'string|required|max:50',
        'codUsuario'           => 'integer|required'
    ];

    public function Usuario(){
      return $this->hasOne(Usuario::class, 'codUsuario', 'codUsuario');
    }
}
