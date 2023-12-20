<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\DetalleVenta;
use App\Models\Venta;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\User;


class VentaController extends Controller
{
    //

    function _construct(){
        $this->middleware('permission:ver-venta|crear-venta|editar-venta|borrar-venta', ['only'=>['index']]);
        $this->middleware('permission:crear-venta', ['only'=>['create','store']]);
        $this->middleware('permission:editar-venta', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-venta', ['only'=>['destroy']]);
    }



    public function VentasById()
    {
        $user = Auth::user();
        $idUsuario = $user->id;

        $ventas = Venta::where('idusuario', $idUsuario)->paginate(10);
        return view('ventas.list', compact('ventas'));
    }

    public function index()
    {
        $ventas = Venta::paginate(10);

        for ($i = 0; $i < count($ventas); $i++) {
            $cliente = User::find($ventas[$i]['idusuario']);
            $ventas[$i]['idcliente'] = $cliente->name;
        }

        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $productos = Producto::where('stock', '>', 0)->get();
        $clientes = Persona::all();

        return view('ventas.crear', compact('productos', 'clientes'));
    }

    public function buscarProductos(Request $request)
    {
        $productos = Producto::where('nombre', 'like', '%' . $request->get('term') . '%')->get(['id', 'nombre']);

        return response()->json($productos);
    }

    public function store(Request $request)
    {
        // Validar los datos de la venta
        $request->validate([
            'idcliente' => 'required',

            'productos.*' => 'required',
            'descuento.*' => 'required',
            'cantidad.*' => 'required|integer|min:1',
        ]);

        $request['num_comprobante'] = $request->num_comprobante ?? "000000";
        $impuesto=0;
        if($request->tipo_comprobante == "recibo"){
            $impuesto = 0.15;
        }


        // Crear una nueva venta
        $venta = Venta::create([
            'idcliente' => $request->idcliente,
            'idusuario' => auth()->id(),
            'tipo_comprobante'=> $request->tipo_comprobante,
            'serie_comprobante'=> $request->serie_comprobante,
            'num_comprobante'=> $request->num_comprobante,
            'fecha_hora'=> now() ,
            'impuesto'=> $impuesto,
            'total' => 0, // Se actualizará más adelante
            'estado' => 'Pendiente',
        ]);

        // Calcular el total de la venta y crear los detalles de venta
        $totalVenta = 0;
        foreach ($request->productos as $index => $idProducto) {
            $subcadenas = explode(" ", $idProducto);
            $producto = Producto::findOrFail($subcadenas[0]);
            $cantidad = $request->cantidad[$index];
            $precio = $producto->precio_venta;
            $descuento = $request->descuento[$index];

            $subtotal = $precio * $cantidad;
            $totalVenta += ($subtotal - $descuento);

            DetalleVenta::create([
                'idventa' => $venta->id,
                'idproducto' => $subcadenas[0],
                'cantidad' => $cantidad,
                'precio' => $precio,
                'descuento' => $descuento,
            ]);

            // Actualizar el stock del producto
            $producto->stock -= $cantidad;
            $producto->save();
        }

        // Actualizar el total de la venta
        $venta->impuesto = $totalVenta *$impuesto ;
        // Actualizar el total de la venta
        $venta->total = $totalVenta ;
        $venta->estado ="Concluido" ;
        $venta->save();

        return redirect()->route('ventas.index')->with('success', 'Venta creada exitosamente.');
    }

    public function show($id)
    {
         //        $productos = Producto::where('stock', '>', 0)->get();
         $venta = Venta::find($id);

         // Obtener el nombre del usuario
         $usuario = User::find($venta->idusuario)->name;
         // Obtener los detalles de la venta
         $detalles = DetalleVenta::where('idventa', $id)->get();

         for ($i = 0; $i < count($detalles); $i++) {
             $producto = Producto::find($detalles[$i]['idproducto']);
             $detalles[$i]['idproducto'] = $producto->nombre;
         }
         $productos = Producto::where('stock', '>', 0)->get();

         return view('ventas.show', compact('venta', 'productos','usuario', 'detalles'));

     }

    public function edit($id)
    {
        $venta = Venta::findOrFail($id);
        $clientes = Persona::all();
        $productos = Producto::all();

        return view('ventas.editar', compact('venta', 'clientes', 'productos'));
    }


    public function update(Request $request, $id)
    {
        // Validar los datos de la venta
        $request->validate([
            'idcliente' => 'required',

            'productos.*' => 'required',
            'descuento.*' => 'required',
            'cantidad.*' => 'required|integer|min:1',
        ]);

        $request['num_comprobante'] = $request->num_comprobante ?? "000000";
        $impuesto=0;
        if($request->tipo_comprobante == "recibo"){
            $impuesto = 0.15;
        }

        $venta = Venta::findOrFail($id);
        $venta->idcliente = $request->idcliente;
        $venta->tipo_comprobante = $request->tipo_comprobante;
        $venta->serie_comprobante = $request->serie_comprobante;
        $venta->num_comprobante = $request->num_comprobante;
        $venta->save();

        // Eliminar los detalles de venta existentes
        $venta->detalleVentas()->delete();

        // Crear los nuevos detalles de venta
        // Calcular el total de la venta y crear los detalles de venta
        $totalVenta = 0;
        foreach ($request->productos as $index => $idProducto) {
            $subcadenas = explode(" ", $idProducto);
            $producto = Producto::findOrFail($subcadenas[0]);
            $cantidad = $request->cantidad[$index];
            $precio = $producto->precio_venta;
            $descuento = $request->descuento[$index];

            $subtotal = $precio * $cantidad;
            $totalVenta += ($subtotal - $descuento);

            DetalleVenta::create([
                'idventa' => $venta->id,
                'idproducto' => $subcadenas[0],
                'cantidad' => $cantidad,
                'precio' => $precio,
                'descuento' => $descuento,
            ]);

            // Actualizar el stock del producto
            $producto->stock -= $cantidad;
            $producto->save();
        }

        // Actualizar el total de la venta
        $venta->impuesto = $totalVenta *$impuesto ;
        // Actualizar el total de la venta
        $venta->total = $totalVenta ;
        $venta->estado ="Concluido" ;
        $venta->save();

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }


    public function destroy($id)
    {
        //
        $venta = Venta::find($id);
        Venta::find($id)->delete();



        return redirect()->route('ventas.index');
    }


}
