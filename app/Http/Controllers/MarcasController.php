<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Marcas;
class MarcasController extends Controller
{
    public function index(Request $request)
    {

        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if($buscar==''){
            $marcas= Marcas::orderBy('id','desc')->paginate(3);

        } else{
            $marcas= Marcas::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
        }

        return[

            'pagination' => [
            'total'            => $marcas->total(),
            'current_page'     => $marcas->currentPage(),
            'per_page'         => $marcas->perPage(),
            'last_page'        => $marcas->lastPage(),
            'from'             => $marcas->firstItem(),
            'to'               => $marcas->lastItem(),
            ],

            'marcas' =>$marcas

        ];
    }

    public function selectMarca(Request $request){
        // if (!$request->ajax()) return redirect('/');
        $marcas = Marcas::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return [
            'marcas' => $marcas
        ];
    }

    public function store(Request $request)
    {
        
        $marcas= new Marcas();
        $marcas->nombre= $request->nombre;
        $marcas->save();
    }

    public function update(Request $request)
    {
    
        $marcas= Marcas::findOrFail($request->id);
        $marcas->nombre= $request->nombre;
        $marcas->save();
    }    
    public function desactivar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $marcas = Marcas::findOrFail($request->id);
        $marcas->condicion = '0';
        $marcas->save();
    }

    public function activar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $marcas = Marcas::findOrFail($request->id);
        $marcas->condicion = '1';
        $marcas->save();
    }
}
