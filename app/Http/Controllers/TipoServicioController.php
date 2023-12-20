<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TipoServicio;
use App\Models\Producto;


class TipoServicioController extends Controller
{

    function _construct(){
        $this->middleware('permission:ver-tipo_servicio|crear-tipo_servicio|editar-tipo_servicio|borrar-tipo_servicio', ['only'=>['index']]);
        $this->middleware('permission:crear-tipo_servicio', ['only'=>['create','store']]);
        $this->middleware('permission:editar-tipo_servicio', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-tipo_servicio', ['only'=>['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tiposServicios = TipoServicio::paginate(10);
        return view('tipo_servicios.index', compact('tiposServicios'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos= Producto::all();
        return view('tipo_servicios.crear', compact('productos'));
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
        TipoServicio::create($request->all());
        return redirect()->route('tipo_servicios.index')->with('success', 'Tipo de servicio creado exitosamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoServicio  $tipoServicio
     * @return \Illuminate\Http\Response
     */
    public function show(TipoServicio $tipoServicio)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoServicio  $tipoServicio
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoServicio $tipoServicio)
    {
        //
        $productos= Producto::all();

        return view('tipo_servicios.editar', compact('tipoServicio','productos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoServicio  $tipoServicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoServicio $tipoServicio)
    {
        //
        $tipoServicio->update($request->all());
        return redirect()->route('tipo_servicios.index')->with('success', 'Tipo de servicio actualizado exitosamente.');
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoServicio  $tipoServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoServicio $tipoServicio)
    {
        //
        $tipoServicio->delete();
        return redirect()->route('tipo_servicios.index')->with('success', 'Tipo de servicio eliminado exitosamente.');

    }
}
