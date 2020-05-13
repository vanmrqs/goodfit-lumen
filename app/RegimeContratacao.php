<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegimeContratacao extends Model
{
    protected $table      = 'tbRegimeContratacao';
    protected $primaryKey = 'codRegimeContratacao';
    protected $fillable   = ['nomeRegimeContratacao'];

    public static $rules  = [
        'nomeRegimeContratacao' => 'string|required|min:6|max:70'
    ];
}
