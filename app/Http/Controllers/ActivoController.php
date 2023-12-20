<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use Illuminate\Http\Request;

class ActivoController extends Controller
{

    function _construct(){
        $this->middleware('permission:ver-activo|crear-activo|editar-activo|borrar-activo', ['only'=>['index']]);
        $this->middleware('permission:crear-activo', ['only'=>['create','store']]);
        $this->middleware('permission:editar-activo', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-activo', ['only'=>['destroy']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $activos = Activo::paginate(10);
        return view('activos.index', compact('activos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('activos.crear');
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
        $this->validate($request, [
            'nombre'=> 'required',
            'detalle'=> 'required',
            'f_adquisicion'=>'required',
            'f_mantenimiento'=>'required']);

        Activo::create($request->all());


        return redirect()->route('activos.index');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Activo $activo)
    {
        //
        return view('activos.editar', compact('activo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Activo $activo)
    {
        //
        $this->validate($request, [
            'nombre'=> 'required',
            'detalle'=> 'required',
            'f_adquisicion'=>'required',
            'f_mantenimiento'=>'required',
            'estado'=>'required']);

        $activo->update($request->all());


        return redirect()->route('activos.index');
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
        Activo::delete();


        return redirect()->route('activos.index');
    }
}
