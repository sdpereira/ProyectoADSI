<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $fillable =[
        'id_categoria','codigo','nombre','precio_venta','stock','descripcion','condicion'
    ];
    public function categorias(){
        return $this->belongsTo('App\Categorias');
    }
}
