<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class animal extends Model
{
    use HasFactory;
    protected $table = 'animais';
    protected $fillable = ['tutor_id', 'nome', 'foto', 'especie_id', 'raca'];

    public function rules()
    {
        return [
            'nome' => 'min:3|max:20',
            'foto' => 'required|file|mimes:png',
            'especie_id' => 'exists:especies,id',
            'raca' => 'required',
            'tutor_id' => 'exists:tutores,id'
        ];
    }
    public function feedback()
    {
        return [
            'exists' => 'Campo :attribute invalido',
            'required' => 'Campo :attribute obrigatório',
            'nome.min' => 'Campo :attribute precisa no minimo de 3 caracteres',
            'nome.max' => 'Campo :attribute precisa no máximo de 20 caracteres',
            'foto.mimes' => 'Campo :attribute precisa ser do tipo .png',
        ];
    }
    public function tutor()
    {
        //relacionamento 1xN com tutores 
        return $this->belongsTo('App\Models\tutor');
    }
}
