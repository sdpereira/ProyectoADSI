<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudades extends Model
{
    protected $fillable=[
        'id','nombre','id_departamento'];
        public $timestamps=false;
}
