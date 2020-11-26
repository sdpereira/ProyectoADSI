<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    protected $fillable = ['nombre','descripcion','condicion'];

    public function produtos()
    {
        return $this->hasMany('App\Productos');
    }
}
