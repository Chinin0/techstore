<?php

namespace App\Http\Controllers;

use App\Models\DetalleAtencion;
use App\Models\AtencionClinica;
use App\Models\Servicio;
use App\Models\DetalleServicio;
use App\Models\TipoServicio;
use App\Models\Contrato;
use App\Models\Producto;
use App\Models\Persona;
use App\Models\Paciente;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    function _construct(){
        $this->middleware('permission:ver-servicio|crear-servicio|editar-servicio|borrar-servicio', ['only'=>['index']]);
        $this->middleware('permission:crear-servicio', ['only'=>['create','store']]);
        $this->middleware('permission:editar-servicio', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-servicio', ['only'=>['destroy']]);
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $servicios = Servicio::paginate(10);

        for ($i = 0; $i < count($servicios); $i++) {
            $medico = Persona::find($servicios[$i]['idmedico']);
            $servicios[$i]['idmedico'] = $medico->nombre;

            $paciente = Paciente::find($servicios[$i]['idpaciente']);
            $servicios[$i]['idpaciente'] = $paciente->nombre;
        }

        return view('servicios.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $pacientes = Paciente::all();
        $personas = Persona::all();
        $tiposervicios = TipoServicio::all();
        $medicos = Persona::whereHas('contratos', function ($query) {
            $query->where('detalle', 'Medico Veterinario')->where('estado', 1);
        })->get();

        return view('servicios.crear', compact('pacientes','personas','tiposervicios','medicos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request;
        //
        // Validar los datos de la ingreso
        $request->validate([
            'idmedico' => 'required',
            'responsable' => 'required',
            'idpaciente' => 'required',
            'servicios.*' => 'nullable',
            'precio.*' => 'nullable',
            'motivo' => 'nullable',
            'atencion.*' => 'nullable',
            'costo.*' => 'nullable',
        ]);


        // Crear una nueva Servicio
        $servicio = Servicio::create([
            'responsable' => $request->responsable,
            'idpaciente'=> $request->idpaciente,
            'idmedico' => $request->idmedico,
            'fecha'=> now() ,
            'total' => 0, // Se actualizará más adelante
        ]);
//        return $servicio;

        // Calcular el total del Servicio y crear los detalles de Servicio
        $totalServicio = 0;
        //servicios de control
        if($request->servicio){

            foreach ($request->servicio as $index => $idservicio) {
                $subcadenas = explode(" ", $idservicio);
                $tipo = TipoServicio::find($subcadenas[0]);
                $producto = Producto::find($tipo->idProducto);
                $subtotal =$request->precio[$index];
                $totalServicio += ($subtotal );

                DetalleServicio::create([
                    'idservicio' => $servicio->id,
                    'tipo_servicio' => 'Control',
                    'nro_servicio' => $subcadenas[0],
                    'costo' => $subtotal,
                ]);
//                return $tipo;
                // Actualizar el stock del producto
                $producto->stock -= 1;
                $producto->save();
            }

        }

//atencion clinica
        if($request->motivo){

            $detalleservicio = DetalleServicio::create([
                'idservicio' => $servicio->id,
                'tipo_servicio' => 'Atencion Clinica',
                'nro_servicio' => '1',
                'costo' => 0,
            ]);

                    // Crear una nueva Servicio
            $atencion = AtencionClinica::create([
                'iddetalle_servicio' => $detalleservicio->id,
                'motivo'=> $request->motivo,
                'hr' => now() ,
            ]);
//            return $atencion;
            $costo = 0 ;
            $detalleservicio->nro_servicio = $atencion->id ;
                        //servicios de control
            foreach ($request->atencion as $index => $atenc) {
                $procedimiento =$atenc;
                $subtotal =$request->costo[$index];
                $costo += ($subtotal );
                $detalle = DetalleAtencion::create([
                    'idatencion' => $atencion->id,
                    'detalle_procedimiento' =>  $procedimiento,
                    'costo' => $subtotal,
                ]);
//                return $detalle;
            }
            $detalleservicio->costo = $costo ;
            $detalleservicio->save();
            $totalServicio += ($costo);

        }

        // Actualizar el total del Servicio
        $servicio->total = $totalServicio ;
        $servicio->save();

        return redirect()->route('servicios.index')->with('success', 'Servicio creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
                //        $productos = Producto::where('stock', '>', 0)->get();
                $servicio = Servicio::find($id);
                // Obtener el nombre del cliente
                $servicio['idpaciente'] = Paciente::find($servicio->idpaciente)->nombre;
                $servicio['idmedico'] = Persona::find($servicio->idmedico)->nombre;
                $detalles = DetalleServicio::where('idservicio', $id)
                                            ->where('tipo_servicio','Control')
                                            ->get();
                //control
                for ($i = 0; $i < count($detalles); $i++) {
                    $tipo = TipoServicio::find($detalles[$i]['nro_servicio']);
                    $detalles[$i]['nro_servicio'] = $tipo->servicio;
                }

                $detallesAtencion = DetalleServicio::where('idservicio', $id)
                                            ->where('tipo_servicio','Atencion Clinica')
                                            ->get('nro_servicio');
                $atencion = ([]) ;
                $det_atencion= ([]) ;
                if(!empty($detallesAtencion[0])){
                    $atencion = AtencionClinica::find($detallesAtencion[0]['nro_servicio']);
                    $det_atencion = DetalleAtencion::where('idatencion', $atencion->id)->get();
                }

                return view('servicios.show', compact('servicio', 'detalles', 'detallesAtencion','atencion', 'det_atencion'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Servicio $servicio)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $servicio = Servicio::find($id);
        $atencion;
        $detalles = DetalleServicio::where('idservicio', $id)->get();

        for ($i = 0; $i < count($detalles); $i++) {
            $detalle = DetalleServicio::find($detalles[$i]['id']);
            if ( $detalle->tipo_servicio == 'Atencion Clinica'){
                $atencion = AtencionClinica::find($detalle->nro_servicio);
                if($atencion ){
                    $de_atencion = DetalleAtencion::where('idatencion', $atencion->nro_servicio)->get();
                    for ($j = 0; $j < count($de_atencion); $j++) {
                        DetalleAtencion::find($de_atencion[$j]['id'])->delete();
                    }
                    AtencionClinica::find($atencion->id)->delete();
                }
            }
            DetalleServicio::find( $detalle->id)->delete();
        }

        $servicio->delete();


        return redirect()->route('servicios.index');

    }
}
