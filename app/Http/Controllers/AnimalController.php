<?php

namespace App\Http\Controllers;

use App\Models\animal;
use App\Repositories\AnimalRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Animal $animal)
    {
        $this->animal = $animal;
    }
    public function index(Request $request)
    {
        $animal_repository = new AnimalRepository($this->animal);

        $animais = array();
        if ($request->has('atributos_tutor')) {
            $atributos_tutor = 'tutor:id,' . $request->atributos_tutor;
            $animal_repository->selectAtributosRegistrosRelacionados($atributos_tutor);
        } else {
            $animal_repository->selectAtributosRegistrosRelacionados('tutor');
        }

        if ($request->has('filtro')) {
            $animal_repository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $atributos = $request->atributos;
            $animal_repository->selectAtributos($request->atributos);
        }

        return response()->json($animal_repository->getPagedResponse(5), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate($this->animal->rules(), $this->animal->feedback());

        $imagem = $request->file('foto');
        $imagem_urn = $imagem->store('imagens', 'public');

        $animal = $this->animal->create(
            [
                'tutor_id' => $request->tutor_id,
                'nome' => $request->nome,
                'foto' => $imagem_urn,
                'especie_id' => $request->especie_id,
                'raca' => $request->raca
            ]
        );

        return response()->json($animal, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $animal = $this->animal->with('tutor')->find($id);
        if ($animal === null)
            return response()->json(
                [
                    'erro' => 'animal inexistente'
                ],
                404
            );

        return response()->json($animal, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function edit(animal $animal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $animal = $this->animal->find($id);
        if ($animal === null)
            return response()->json(
                [
                    'erro' => 'animal inexistente'
                ],
                404
            );

        if ($request->method() === 'PATCH') {
            $rules = array();
            foreach ($animal->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $rules[$input] = $regra;
                }
            }
        } else {
            $rules = $animal->rules();
        }
        $request->validate($rules, $animal->feedback());

        if ($imagem = $request->file('foto')) {
            Storage::disk('public')->delete($animal->foto);
            $imagem_urn = $imagem->store('imagens', 'public');
        } else {
            $imagem_urn = $animal->foto;
        }

        $animal->fill($request->all());
        $animal->foto = $imagem_urn;
        $animal->save();


        return response()->json($animal, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $animal = $this->animal->find($id);
        if ($animal === null)
            return response()->json(
                [
                    'erro' => 'animal inexistente'
                ],
                404
            );
        if ($animal->foto) {
            Storage::disk('public')->delete($animal->foto);
        }
        $animal->delete();
        return response()->json(['msg' => 'sucesso'], 200);
    }
}
