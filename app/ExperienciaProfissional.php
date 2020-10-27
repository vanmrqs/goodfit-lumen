<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienciaProfissional extends Model
{
    protected $table	  = 'tbExperienciaProfissional';
    protected $primaryKey = 'codExperienciaProfissional';
    protected $fillable   = [
        'empresaExperienciaProfissional',
        'descricaoExperienciaProfissional',
        'videoExperienciaProfissional',
        'isEmpregoAtualExperienciaProfissional',
        'dataInicioExperienciaProfissional',
        'dataFinalExperienciaProfissional',
        'codProfissao',
        'codCurriculo'
    ];

    public static $rules  = [
        'empresaExperienciaProfissional'        => 'string|required|max:150',
        'descricaoExperienciaProfissional'      => 'string|max:250',
        'videoExperienciaProfissional'          => 'string',
        'isEmpregoAtualExperienciaProfissional' => 'integer|size:1|required',
        'dataInicioExperienciaProfissional'     => 'integer|size:10',
        'dataFinalExperienciaProfissional'      => 'integer|size:10',
        'codProfissao'                          => 'integer',
        'codCurriculo'                          => 'integer',
    ];

    public function Profissao(){
        return $this->hasOne(Profissao::class, 'codProfissao', 'codProfissao');
    }

    public function Curriculo(){
        return $this->hasOne(Curriculo::class, 'codCurriculo', 'codCurriculo');
    }
}
