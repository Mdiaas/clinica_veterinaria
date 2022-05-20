<?php

namespace App\Http\Controllers;

use App\Models\tutor;
use Illuminate\Http\Request;
use App\Repositories\TutorRepository;

class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Tutor $tutor)
    {
        $this->tutor = $tutor;
    }
    public function get_all()
    {
        $tutor_repository = new TutorRepository($this->tutor);
        return response()->json($tutor_repository->getResponse(5), 200);
    }
    public function index(Request $request)
    {
        $tutor_repository = new TutorRepository($this->tutor);

        $tutores = array();
        if ($request->has('atributos_animais')) {
            $atributos_animais = 'animais:tutor_id,' . $request->atributos_animais;
            $tutor_repository->selectAtributosRegistrosRelacionados($atributos_animais);
        } else {
            $tutor_repository->selectAtributosRegistrosRelacionados('animais');
        }

        if ($request->has('filtro')) {
            $tutor_repository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $tutor_repository->selectAtributos($request->atributos);
        }

        return response()->json($tutor_repository->getPagedResponse(5), 200);
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
        $regras = $this->tutor->rules();
        $feedback = $this->tutor->feedback();

        $request->validate($regras, $feedback);

        $tutor = $this->tutor->create($request->all());

        return response()->json($tutor, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tutor = $this->tutor->with('animais')->find($id);
        if ($tutor === null)
            return response()->json([
                'erro' => 'tutor inexistente'
            ], 404);
        return response()->json($tutor, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function edit(tutor $tutor)
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
        $tutor = $this->tutor->find($id);

        $regras = $tutor->rules();
        $feedback = $tutor->feedback();

        if ($request->method() === 'PATCH') {
            $regrasDinamicas = array();
            foreach ($tutor->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $feedback);
        } else
            $request->validate($regras, $feedback);

        if ($tutor === null)
            return response()->json([
                'erro' => 'tutor inexistente'
            ], 404);
        $tutor->update($request->all());
        return response()->json($tutor, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tutor = $this->tutor->find($id);
        if ($tutor === null)
            return response()->json([
                'erro' => 'tutor inexistente'
            ], 404);
        $tutor->delete();
        return response()->json(['msg' => 'sucesso'], 200);
    }
}
