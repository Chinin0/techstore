<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


use App\Models\Pago;
use App\Models\Venta;
use App\Models\Servicio;
use App\Models\Producto;
use Illuminate\Http\Request;


class PagoController extends Controller
{

    function _construct(){
        $this->middleware('permission:ver-pago|crear-pago|editar-pago|borrar-pago', ['only'=>['index']]);
        $this->middleware('permission:crear-pago', ['only'=>['create','store']]);
        $this->middleware('permission:editar-pago', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-pago', ['only'=>['destroy']]);
    }
    //SERVICIO DE CONFIRMACION
    public function confirmarPago(Request $request){
        $NroVenta = $request->input("PedidoID");
        $Fecha = $request->input("Fecha");
        $NuevaFecha = date("Y-m-d", strtotime($Fecha));
        $Hora = $request->input("Hora");
        $MetodoPago = $request->input("MetodoPago");
        $Estado = $request->input("Estado");
        $Ingreso = true;

        try {
            $pago = Pago::where('numero_referencia','=',$NroVenta)->first();
            $venta = Venta::where('num_comprobante','=',$NroVenta)->first();
            if($pago === null || $venta ===null){
                throw new Exception("El pago no se encuentra en la base de datos.");
            }else{
                $pago->estado_pago = 'Aceptado';
                $pago->update();

                foreach($venta->detalleVentas as $detalle) {
                    $producto = $detalle->producto;
                    $producto->stock -= $detalle->cantidad;
                    $producto->save();
                  }
                $venta->estado ="Concluido" ;
                $venta->save();
            }
            $arreglo = ['error' => 0, 'status' => 1, 'message' => "Pago realizado correctamente.", 'values' => true];
        } catch (\Throwable $th) {
            $arreglo = ['error' => 1, 'status' => 1, 'messageSistema' => "[TRY/CATCH] " . $th->getMessage(), 'message' => "No se pudo realizar el pago, por favor intente de nuevo.", 'values' => false];
        }

        return response()->json($arreglo);
    }

    public function PagosById(){

        $user = Auth::user();
        $idUsuario = $user->id;

        $pagos = Pago::where('iduser', $idUsuario)->paginate(10);

        return view('pagos.list', compact('pagos'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pagos = Pago::paginate(10);

        return view('pagos.index', compact('pagos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //traer datos del carrito
        $order = \Cart::session(auth()->id())->getContent();
        $total = \Cart::session(auth()->id())->getTotal();

        //dd($order);
        return view('pagos.crear',compact('order','total'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'iduser' => 'required',
            'nombre' => 'required',
            'numero_referencia' => 'nullable',
            'monto' => 'required',
            'descripcion' => 'nullable',
            'metodo_pago' => 'required',
        ]);




        $subcadenas = explode(" ", $request->idservicio);


        $venta = Pago::create([

            'nombre' => $request->nombre,
            'numero_referencia' => $request->numero_referencia,
            'monto' => $request->monto,
            'descripcion' => $request->descripcion,
            'metodo_pago' => $request->metodo_pago,
            'fecha' => now(),
            'estado_pago' => 'Cancelado',

        ]);

        return redirect()->route('pagos.index')->with('success', 'Pago agregado exitosamente');

    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function show(Pago $pago)
    {
        //



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function edit(Pago $pago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pago $pago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $pago = Pago::findOrFail($id);
        $pago->estado_pago = 'Anulado';
        $pago->save();

        return redirect()->route('pagos.index');
    }
}
