<?php

namespace App\Http\Controllers;

use App\Models\especie;
use Illuminate\Http\Request;
use App\Repositories\EspecieRepository;

class EspecieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Especie $especie)
    {
        $this->especie = $especie;
    }
    public function index()
    {
        $especie_repository = new EspecieRepository($this->especie);
        return response()->json($especie_repository->getResponse(), 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\especie  $especie
     * @return \Illuminate\Http\Response
     */
    public function show(especie $especie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\especie  $especie
     * @return \Illuminate\Http\Response
     */
    public function edit(especie $especie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\especie  $especie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, especie $especie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\especie  $especie
     * @return \Illuminate\Http\Response
     */
    public function destroy(especie $especie)
    {
        //
    }
}
