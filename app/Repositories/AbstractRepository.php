<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function selectAtributosRegistrosRelacionados($atributos)
    {
        $this->model = $this->model->with($atributos);

        return $this->model;
    }
    public function filtro($filtro)
    {
        $filtros = explode(";", $filtro);
        foreach ($filtros as $f) {
            $f = explode(":", $f);
            $this->model = $this->model->where($f[0], $f[1], $f[2]);
        }
        return $this->model;
    }
    public function selectAtributos($atributos)
    {
        $this->model = $this->model->selectRaw($atributos);
    }
    public function getResponse()
    {
        return $this->model->get();
    }
    public function getPagedResponse($registrosPorPagina)
    {
        return $this->model->paginate($registrosPorPagina);
    }
}
