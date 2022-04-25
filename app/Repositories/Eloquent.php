<?php

namespace App\Repositories;

trait Eloquent
{
    public function getAll()
    {
        return $this->model::all();
    }

    public function find($id)
    {
        return $this->model::find($id);
    }

    public function findBy($column, $value)
    {
        return $this->model::where($column, '=', $value);
    }

    public function getFirst()
    {
        return $this->model::first();
    }
}