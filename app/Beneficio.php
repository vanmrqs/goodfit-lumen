<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficio extends Model
{
    protected $table      = 'tbBeneficio';
    protected $primaryKey = 'codBeneficio';
    protected $fillable   = ['nomeBeneficio', 'codVaga'];

    public static $rules  = [
        'nomeBeneficio' => 'string|required|min:6|max:150',
        'codVaga'       => 'integer|required'
    ];

    public function Vaga(){
        return $this->belongsTo(Vaga::class, 'codVaga', 'codVaga');
    }
}
