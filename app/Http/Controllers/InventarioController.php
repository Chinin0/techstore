<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\DetalleVenta;
use App\Models\Inventario;
use App\Models\Activo;



class InventarioController extends Controller
{
    //

    public function index()
    {
        $faltantes = Producto::where('stock', '=', 0)->get();
        $excasos= Producto::where('stock', '<', 3)
                            ->where('stock', '>', 0)
                            ->get();
        $productos = Producto::orderBy('stock', 'asc')->get();

        $inventarios = Inventario::orderBy('idactivo')->paginate(10);

        for ($i = 0; $i < count($inventarios); $i++) {
            $producto = Producto::find($inventarios[$i]['idproducto']);
            $inventarios[$i]['idproducto'] = $producto->nombre.' - '.$producto->stock.' unidades ';

            $Activo = Activo::find($inventarios[$i]['idactivo']);
            $inventarios[$i]['idactivo'] = $Activo->nombre;
        }

        return view('inventarios.index', compact('faltantes','excasos','inventarios'));
    }

    public function create()
    {
        $activos = Activo::all();
        $productos = Producto::whereNotIn('id', function ($query) {
            $query->select('idproducto')
                ->from('inventarios');
        })->get();

        return view('inventarios.crear', compact('activos','productos'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'idactivo' => 'required|integer',
            'idproducto' => 'required|integer',
            'detalle' => 'required',
        ]);

        Inventario::create($data);

        return redirect()->route('inventarios.index')->with('success', 'Inventario creado exitosamente.');
    }

    public function edit(Inventario $inventario)
    {
        //
        $activos = Activo::all();
        $productos = Producto::whereNotIn('id', function ($query) use ($inventario) {
            $query->select('idproducto')
                ->from('inventarios')
                ->where('id', '!=', $inventario->id);
        })->get();

        return view('inventarios.editar', compact('inventario','activos','productos'));
    }


    public function update(Request $request,Inventario $inventario)
    {
        //
        $this->validate($request, [
            'nombre'=> 'required',
            'detalle'=> 'required',
            'f_adquisicion'=>'required',
            'f_mantenimiento'=>'required',
            'estado'=>'required']);

        $inventario->update($request->all());


        return redirect()->route('inventarios.index');
    }

    public function destroy($id)
    {
        //
        Inventario::delete();


        return redirect()->route('inventarios.index');
    }

}
