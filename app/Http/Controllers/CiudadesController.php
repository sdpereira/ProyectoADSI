<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Ciudades;

class CiudadesController extends Controller
{
    public function index(Request $request)
    {
    // if(!$request->ajax()) return redirect('/');
    $buscar   = $request->buscar;
    $criterio = $request->criterio;
    $ciudades = Ciudades::orderBy('id', 'asc')->get();

    if ($buscar == '') {
        $ciudades = Ciudades::join('departamentos', 'ciudades.id_departamento', '=', 'departamentos.id')
            ->select('ciudades.id', 'ciudades.nombre', 'departamentos.nombre as nomDptos')
            ->orderBy('id', 'asc')->paginate(50);
        } else { $ciudades = Ciudades::join('departamentos', 'ciudades.id_departamento', '=', 'departamentos.id')
            ->select('ciudades.id', 'ciudades.nombre', 'departamentos.nombre as nomDptos') 
            ->where( 'ciudades.' .$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id', 'asc')->paginate(50);
        }
            return [
                'pagination' => [
                    'total'        => $ciudades->total(),
                    'current_page' => $ciudades->currentPage(),
                    'per_page'     => $ciudades->perPage(),
                    'last_page'    => $ciudades->lastPage(),
                    'from'         => $ciudades->firstItem(),
                    'to'           => $ciudades->lastItem(),
    
                ],
                'ciudades'  => $ciudades,
            ];
    
}
    public function selectCiudad(Request $request)
    {
        $ciudades=Ciudades::select('id','nombre','id_departamento')
        ->orderBy('nombre','asc')
        ->get();
        return[
            'ciudades'=>$ciudades  
        ];
    }

    public function update(Request $request)
    {
        $ciudades              = Ciudades::findOrfail($request->id);
        $ciudades->nombre      = $request->nombre;
        $ciudades->id_departamento = $request->id_departamento;
        $ciudades->save();
    }
}
