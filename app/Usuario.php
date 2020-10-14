<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Model
{
  protected $table      = 'tbUsuario';
  protected $primaryKey = 'codUsuario';
  protected $fillable   = ['fotoUsuario', 'loginUsuario', 'email', 'password', 'codNivelUsuario', 'token'];

  public static $rules = [
      'fotoUsuario'     => 'string',
      'loginUsuario'    => 'string|required|min:6|max:50|unique:tbusuario',
      'email'           => 'email|required|max:150|unique:tbusuario',
      'password'        => 'string|required|min:8',
      'codNivelUsuario' => 'integer|required',
      'token'           => 'string|size:60'
  ];

  public function nivelUsuario(){
    return $this->hasOne(NivelUsuario::class, 'codNivelUsuario', 'codNivelUsuario');
  }
}
