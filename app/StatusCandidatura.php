<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusCandidatura extends Model
{
    protected $table 	  = 'tbStatusCandidatura';
    protected $primaryKey = 'codStatusCandidatura';
    protected $fillable   = ['nomeStatusCandidatura'];

    public static $rules  = [
        'nomeStatusCandidatura' => 'string|required|min:6|max:50'
    ];
}
