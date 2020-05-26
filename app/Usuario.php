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
  protected $fillable   = ['fotoUsuario', 'loginUsuario', 'email', 'password', 'codNivelUsuario'];

  public static $rules = [
      'fotoUsuario'     => 'string|required',
      'loginUsuario'    => 'string|required|min:6|max:50',
      'email'           => 'email|required|max:150',
      'password'        => 'string|required',
      'codNivelUsuario' => 'integer|required'
  ];

  public function nivelUsuario(){
    return $this->hasOne(NivelUsuario::class, 'codNivelUsuario', 'codNivelUsuario');
  }
}
