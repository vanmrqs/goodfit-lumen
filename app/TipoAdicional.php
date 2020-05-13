<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAdicional extends Model
{
    protected $table      = 'tbTipoAdicional';
    protected $primaryKey = 'codTipoAdicional';
    protected $fillable   = ['nomeTipoAdicional', 'escalonavelTipoAdicional'];

    public static $rules  = [
        'nomeTipoAdicional'        => 'string|required|min:3|max:100',
        'escalonavelTipoAdicional' => 'integer|required|boolean'
    ];
}
