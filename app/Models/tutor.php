<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class tutor extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'tutores';
    protected $fillable = ['nome', 'logradouro', 'bairro', 'cidade', 'UF', 'CEP', 'sexo', 'CPF', 'RG'];

    public function rules()
    {
        return [
            'nome' => 'min:3|max:50',
            'logradouro' => 'min:5|max:60',
            'bairro' => 'min:5|max:50',
            'cidade' => 'min:5|max:15',
            'UF' => 'min:2|max:2',
            'CEP' => 'min:8|max:8',
            'sexo' => 'min:1|max:1',
            'CPF' => "min:11|max:11|", Rule::unique('tutores', 'CPF')->ignore($this->id),
            'RG' => 'min:7|max:12|unique:tutores,RG,' . $this->id . ''
        ];
    }
    public function feedback()
    {
        return [
            'min' => 'O campo :attribute não foi preenchido corretamente, verifique o tamanho do texto',
            'unique' => 'O campo :attribute já foi cadastrado em outro tutor',
            'max' => 'O campo :attribute não foi preenchido corretamente, verifique o tamanho do texto'
        ];
    }
    public function animais()
    {
        //relacionamento 1xN
        return $this->hasMany('App\Models\animal');
    }
}
