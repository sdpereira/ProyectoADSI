<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Departamentos;

class DepartamentosController extends Controller
{

    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $departamentos = Departamentos::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $departamentos = Departamentos::where('departamentos.' .$criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $departamentos->total(),
                'current_page' => $departamentos->currentPage(),
                'per_page'     => $departamentos->perPage(),
                'last_page'    => $departamentos->lastPage(),
                'from'         => $departamentos->firstItem(),
                'to'           => $departamentos->lastItem(),
            ],
            'departamentos' => $departamentos
        ];
    } 
    public function selectDpto(Request $request)
    {
        $departamentos = Departamentos::select('id', 'nombre')
            ->orderBy('nombre', 'asc')->get();
        return [
            'departamentos' => $departamentos
        ];
    }

    public function store(Request $request)
    {
        $departamentos         = new Departamentos();
        $departamentos->nombre = $request->nombre;
        $departamentos->save();
    }

    public function update(Request $request)
    {
        $departamentos         = Departamentos::findOrFail($request->id);
        $departamentos->nombre = $request->nombre;
        $departamentos->save();
    }

    public function destroy(Request $request)
    {
        $departamentos = Departamentos::findOrFail($request->id);
        $departamentos->delete();
    }
}

