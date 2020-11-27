<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorias;

class CategoriasController extends Controller
{

    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $categorias = Categorias::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $categorias = Categorias::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $categorias->total(),
                'current_page' => $categorias->currentPage(),
                'per_page'     => $categorias->perPage(),
                'last_page'    => $categorias->lastPage(),
                'from'         => $categorias->firstItem(),
                'to'           => $categorias->lastItem(),
            ],
            'categorias' => $categorias
        ];
    }   
    public function selectCategoria(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Categorias::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['categorias' => $categorias];
    }

    public function store(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $categorias = new Categorias();
        $categorias->nombre = $request->nombre;
        $categorias->descripcion = $request->descripcion;
        $categorias->condicion = '1';
        $categorias->save();
    }

    public function update(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $categorias = Categorias::findOrFail($request->id);
        $categorias->nombre = $request->nombre;
        $categorias->descripcion = $request->descripcion;
        $categorias->condicion = '1';
        $categorias->save();
    }

    public function desactivar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $categorias = Categorias::findOrFail($request->id);
        $categorias->condicion = '0';
        $categorias->save();
    }

    public function activar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $categorias = Categorias::findOrFail($request->id);
        $categorias->condicion = '1';
        $categorias->save();
    }
    
    // public function destroy(Request $request)
    // {
    //     $categorias = Categorias::findOrFail($request->id);
    //     $categorias->delete();
    // }

    
}
