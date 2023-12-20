<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Servicio;
use App\Models\Receta;
use App\Models\DetalleReceta;
use App\Models\AtencionClinica;
class RecetaController extends Controller
{

    function _construct(){
        $this->middleware('permission:ver-receta|crear-receta|editar-receta|borrar-receta', ['only'=>['index']]);
        $this->middleware('permission:crear-receta', ['only'=>['create','store']]);
        $this->middleware('permission:editar-receta', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-receta', ['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $recetas = Receta::paginate(10);
        return view('recetas.index', compact('recetas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $servicios = Servicio::orderBy('fecha', 'desc')->get();
        return view('recetas.crear', compact('servicios'));
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
        $subcadenas = explode(" ", $request->idatencion);
        $atencion = Servicio::findOrFail($subcadenas[0]);

        $receta = Receta::create([
            'idatencion' => $atencion->id,
            'numero_recetario' => $request->numero_recetario,
            'estado' => 'Sin Asignar',
        ]);

        foreach ($request->productos as $index => $idProducto) {
            DetalleReceta::create([
                'idreceta' => $receta->id,
                'nombre_producto' => $request->productos[0],
                'indicaciones' => $request->indicaciones[0],
            ]);
        }
        $receta->estado = 'Asignado';
        $receta->save();
        return redirect()->route('recetas.index')->with('success', 'Receta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $receta = Receta::find($id);
        $detalles = DetalleReceta::where('idreceta', $id)->get();
        return view('recetas.show', compact('receta','detalles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $pago = Receta::findOrFail($id);
        $pago->estado = 'Anulado';
        $pago->save();
        return redirect()->route('recetas.index');
    }
}
