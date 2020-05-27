<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class RequisitoVaga extends Model {
    protected $table      = 'tbRequisitoVaga';
    protected $primaryKey = 'codRequisitoVaga';
    protected $fillable   = ['obrigatoriedadeRequisitoVaga', 'codAdicional', 'codVaga'];

    public static $rules  = [
        'obrigatoriedadeRequisitoVaga' => 'required|boolean|integer',
        'codAdicional'                 => 'required|integer',
        'codVaga'                      => 'required|integer'
    ];
}
