<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\DetalleIngreso;
use App\Models\Ingreso;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Contrato;
use App\Models\User;

class IngresoController extends Controller
{
    //

    function _construct(){
        $this->middleware('permission:ver-ingreso|crear-ingreso|editar-ingreso|borrar-ingreso', ['only'=>['index']]);
        $this->middleware('permission:crear-ingreso', ['only'=>['create','store']]);
        $this->middleware('permission:editar-ingreso', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-ingreso', ['only'=>['destroy']]);
    }




    public function index()
    {
        $ingresos = Ingreso::paginate(10);

        for ($i = 0; $i < count($ingresos); $i++) {


            $proveedor = Persona::find($ingresos[$i]['idproveedor']);
            $ingresos[$i]['idproveedor'] = $proveedor->nombre;
        }

        return view('ingresos.index', compact('ingresos'));
    }

    public function create()
    {
        $productos = Producto::all();

        $proveedores = DB::table('personas')
        ->leftJoin('contratos', 'personas.id', '=', 'contratos.idpersonal')
        ->where('contratos.detalle', 'Proveedor')
        ->select('personas.*')
        ->get();

        return view('ingresos.crear', compact('productos', 'proveedores'));
    }

    public function store(Request $request)
    {
        // Validar los datos de la ingreso
        $request->validate([
            'idproveedor' => 'required',

            'productos.*' => 'required',
            'precio.*' => 'required',
            'cantidad.*' => 'required|integer|min:1',
        ]);

        $request['num_comprobante'] = $request->num_comprobante ?? "000000";
        $impuesto=0;
        if($request->tipo_comprobante == "recibo"){
            $impuesto = 0.15;
        }


        // Crear una nueva ingreso
        $ingreso = Ingreso::create([
            'idproveedor' => $request->idproveedor,
            'idusuario' => auth()->id(),
            'tipo_comprobante'=> $request->tipo_comprobante,
            'serie_comprobante'=> $request->serie_comprobante,
            'num_comprobante'=> $request->num_comprobante,
            'fecha'=> now() ,
            'impuesto'=> $impuesto,
            'total' => 0, // Se actualizará más adelante
            'estado' => 'Pendiente',
        ]);

        // Calcular el total de la ingreso y crear los detalles de ingreso
        $totalVenta = 0;
        foreach ($request->productos as $index => $idProducto) {
            $subcadenas = explode(" ", $idProducto);
            $producto = Producto::findOrFail($subcadenas[0]);
            $cantidad = $request->cantidad[$index];
            $precio = $request->precio[$index];

            $subtotal = $precio * $cantidad;
            $totalVenta += ($subtotal );

            DetalleIngreso::create([
                'idingreso' => $ingreso->id,
                'idproducto' => $subcadenas[0],
                'cantidad' => $cantidad,
                'precio' => $precio,
            ]);

            // Actualizar el stock del producto
            $producto->stock += $cantidad;
            $producto->save();
        }

        // Actualizar el total de la ingreso
        $ingreso->impuesto = $totalVenta *$impuesto ;
        // Actualizar el total de la ingreso
        $ingreso->total = $totalVenta ;
        $ingreso->estado ="Concluido" ;
        $ingreso->save();

        return redirect()->route('ingresos.index')->with('success', 'Venta creada exitosamente.');
    }

    public function show($id)
    {
        //        $productos = Producto::where('stock', '>', 0)->get();
        $ingreso = Ingreso::find($id);
        // Obtener el nombre del cliente
        $proveedor = Persona::find($ingreso->idproveedor)->nombre;
        // Obtener el nombre del usuario
        $usuario = User::find($ingreso->idusuario)->name;
        // Obtener los detalles de la ingreso
        $detalles = DetalleIngreso::where('idingreso', $id)->get();

        for ($i = 0; $i < count($detalles); $i++) {
            $producto = Producto::find($detalles[$i]['idproducto']);
            $detalles[$i]['idproducto'] = $producto->nombre;
        }
        $productos = Producto::all();

        return view('ingresos.show', compact('ingreso', 'productos', 'proveedor','usuario', 'detalles'));

    }

    public function edit($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $proveedores = DB::table('personas')
        ->leftJoin('contratos', 'personas.id', '=', 'contratos.idpersonal')
        ->where('contratos.detalle', 'Proveedor')
        ->select('personas.*')
        ->get();
        $productos = Producto::all();
        $detalles = DetalleIngreso::where('idingreso', $id)->get();
        return view('ingresos.editar', compact('ingreso', 'proveedores', 'productos', 'detalles'));
    }


    public function update(Request $request, $id)
    {
        // Validar los datos de la ingreso
        $request->validate([
            'idproveedor' => 'required',

            'productos.*' => 'required',
            'descuento.*' => 'required',
            'cantidad.*' => 'required|integer|min:1',
        ]);

        $request['num_comprobante'] = $request->num_comprobante ?? "000000";
        $impuesto=0;
        if($request->tipo_comprobante == "recibo"){
            $impuesto = 0.15;
        }

        $ingreso = Venta::findOrFail($id);
        $ingreso->idproveedor = $request->idproveedor;
        $ingreso->tipo_comprobante = $request->tipo_comprobante;
        $ingreso->serie_comprobante = $request->serie_comprobante;
        $ingreso->num_comprobante = $request->num_comprobante;
        $ingreso->save();

        // Eliminar los detalles de ingreso existentes
        $ingreso->detalleVentas()->delete();

        // Crear los nuevos detalles de ingreso
        // Calcular el total de la ingreso y crear los detalles de ingreso
        $totalVenta = 0;
        foreach ($request->productos as $index => $idProducto) {
            $subcadenas = explode(" ", $idProducto);
            $producto = Producto::findOrFail($subcadenas[0]);
            $cantidad = $request->cantidad[$index];
            $precio = $producto->precio_ingreso;
            $descuento = $request->descuento[$index];

            $subtotal = $precio * $cantidad;
            $totalVenta += ($subtotal - $descuento);

            DetalleVenta::create([
                'idingreso' => $ingreso->id,
                'idproducto' => $subcadenas[0],
                'cantidad' => $cantidad,
                'precio' => $precio,
                'descuento' => $descuento,
            ]);

            // Actualizar el stock del producto
            $producto->stock -= $cantidad;
            $producto->save();
        }

        // Actualizar el total de la ingreso
        $ingreso->impuesto = $totalVenta *$impuesto ;
        // Actualizar el total de la ingreso
        $ingreso->total = $totalVenta ;
        $ingreso->estado ="Concluido" ;
        $ingreso->save();

        return redirect()->route('ingresos.index')->with('success', 'Venta actualizada correctamente.');
    }


    public function destroy($id)
    {
        //
        $ingreso = Venta::find($id);
        Venta::find($id)->delete();



        return redirect()->route('ingresos.index');
    }

}
