<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $fillable=[
        'id','nombre','tipo_documento','num_documento','direccion',
        'telefono','email','id_ciudad',];
        public $timestamps=false;
}
