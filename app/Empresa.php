<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Usuario;

class Empresa extends Model
{
    protected $table      = 'tbEmpresa';
    protected $primaryKey = 'codEmpresa';
    protected $fillable   = ['razaoSocialEmpresa', 'nomeFantasiaEmpresa', 'cnpjEmpresa', 'codUsuario'];

    public static $rules  = [
        'razaoSocialEmpresa'  => 'string|required|min:6|max:200',
        'nomeFantasiaEmpresa' => 'string|required|max:200',
        'cnpjEmpresa'         => 'string|required|size:14',
        'codUsuario'          => 'integer|required'
    ];

    public function Usuario(){
    	return $this->hasOne(Usuario::class, 'codUsuario', 'codUsuario');
    }
}
