<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller
{
    //

    function _construct(){
        $this->middleware('permission:ver-producto|crear-producto|editar-producto|borrar-producto', ['only'=>['index']]);
        $this->middleware('permission:crear-producto', ['only'=>['create','store']]);
        $this->middleware('permission:editar-producto', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-producto', ['only'=>['destroy']]);
    }



    public function index()
    {
        $productos = Producto::paginate(10);

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.crear', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idcategoria' => 'required',
            'codigo' => 'nullable',
            'nombre' => 'required|unique:productos',
            'precio_venta' => 'required',
            'stock' => ['required', 'numeric', 'min:2'],
            'descripcion' => 'nullable',
            'estado' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Procesa la imagen y guárdala en tu sistema de archivos
        $imagen = $request->file('imagen');
        $nombreImagen = time() . '.' . $imagen->getClientOriginalName();
        $ruta = 'img/productos';
        $imagen->move($ruta, $nombreImagen);

        // Crea el producto con la información del formulario y la ruta de la imagen
        Producto::create(array_merge($request->all(), ['imagen' => $ruta.'/'.$nombreImagen]));

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('productos.editar', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'idcategoria' => 'required',
            'codigo' => 'nullable',
            'nombre' => 'required|unique:productos,nombre,'.$id,
            'precio_venta' => 'required',
            'stock' => 'required',
            'descripcion' => 'nullable',
            'estado' => 'required',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }

    public function buscar(Request $request)
    {
        // Obtener los valores de fecha de inicio y fecha de fin del formulario
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Realizar la lógica de búsqueda de productos con mayor demanda
        $demandas = Producto::whereHas('detalleVentas', function ($query) use ($fechaInicio, $fechaFin) {
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        })
        ->withCount(['detalleVentas as demanda_total' => function ($query) use ($fechaInicio, $fechaFin) {
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }])
        ->orderByDesc('demanda_total')
        ->get();

        return view('productos.buscar', compact('demandas'));
    }

}
