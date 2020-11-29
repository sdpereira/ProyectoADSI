<?php

namespace App\Http\Controllers;
use App\Productos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index(Request $request)
    {
    
        $buscar= $request->buscar;
        $criterio= $request->criterio;
        // $productos = Productos::orderBy('nombre', 'asc')->get();
        if($buscar==''){

            $productos= Productos::join('categorias','productos.id_categoria','=','categorias.id')
            ->join('marcas','productos.id_marca','=','marcas.id')
            
            ->select('productos.id',
            'productos.nombre',
            'productos.codigo',
            'productos.precio_venta',
            'productos.stock',
            'productos.condicion',
            'categorias.nombre as nomCat',
            'marcas.nombre as nomMr')
            ->orderBy('productos.nombre', 'desc')->paginate(3);

        } else{

            $productos = Productos::join('categorias','productos.id_categoria','=','categorias.id')
            ->join('marcas','productos.id_marca','=','marcas.id')
            ->select('productos.id',
            'productos.nombre',
            'productos.codigo',
            'productos.precio_venta',
            'productos.stock',
            'productos.condicion',
            'categorias.nombre as nomCat',
            'marcas.nombre as nomMr')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.nombre', 'desc')->paginate(3);
        } 
        return[

            'pagination' => [
            'total'            => $productos->total(),
            'current_page'     => $productos->currentPage(),
            'per_page'         => $productos->perPage(),
            'last_page'        => $productos->lastPage(),
            'from'             => $productos->firstItem(),
            'to'               => $productos->lastItem(),           
            ],

            'productos' =>$productos

        ];
    }
    public function listarProducto(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $productos = Productos::join('categorias','productos.id_categoria','=','categorias.id')
            ->join('marcas','productos.id_marca','=','marcas.id')
            ->select('productos.id','productos.id_categoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else{
            $productos = Productos::join('categorias','productos.id_categoria','=','categorias.id')
            ->join('marcas','productos.id_marca','=','marcas.id')
            ->select('productos.id','productos.id_categoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        

        return ['productos' => $productos];
    }
     
    public function listarProductoVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $productos = Productos::join('categorias','productos.id_categoria','=','categorias.id')
            ->join('marcas','productos.id_marca','=','marcas.id')
            ->select('productos.id','productos.id_categoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else{
            $productos = Productos::join('categorias','productos.id_categoria','=','categorias.id')
            ->join('marcas','productos.id_marca','=','marcas.id')
            ->select('productos.id','productos.id_categoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.precio_venta','productos.stock','productos.condicion')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(10);

        return ['productos' => $productos];
    }
}

    public function store(Request $request)
    {
        $productos= new Productos();
        $productos->nombre = $request->nombre;
        $productos->codigo = $request->codigo;
        $productos->precio_venta = $request->precio_venta;
        $productos->stock = $request->stock;
        $productos->condicion='1';
        $productos->id_categoria = $request->id_categoria;
        $productos->id_marca = $request->id_marca;

        
        $productos->save();
    }

    public function update(Request $request)
    {
    
        $productos= Productos::findOrFail($request->id);
        $productos->codigo = $request->codigo;
        $productos->nombre = $request->nombre;
        $productos->precio_venta = $request->precio_venta;
        $productos->stock = $request->stock;
        $productos->condicion='1';
        $productos->id_categoria = $request->id_categoria;
        $productos->id_marca = $request->id_marca;
        $productos->save();
    }
    
    public function desactivar(Request $request)
    {
        $productos= Productos::findOrFail($request->id);
        $productos->condicion= '0';
        $productos->save();
    }

    public function activar(Request $request)
    {
        $productos= Productos::findOrFail($request->id);
        $productos->condicion= '1';
        $productos->save();
    }
    
    public function destroy(Request $request)
    {
        $productos = Productos::findOrFail($request->id);
        $productos->delete();
    }
    public function buscarProducto(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $productos = Productos::where('codigo','=', $filtro)
        ->select('id','nombre')->orderBy('nombre', 'asc')->take(1)->get();

        return ['productos' => $productos];
    }

    public function buscarProductoVenta(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $productos = Productos::where('codigo','=', $filtro)
        ->select('id','nombre','stock','precio_venta')
        ->where('stock','>','0')
        ->orderBy('nombre', 'asc')
        ->take(1)->get();

        return ['productos' => $productos];
    }
}    


