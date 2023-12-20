<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $contratos = Contrato::paginate(10);

        for ($i = 0; $i < count($contratos); $i++) {
            $persona = Persona::find($contratos[$i]['idpersonal']);
            $contratos[$i]['idpersonal'] = $persona->nombre;
            $ususario = User::find($contratos[$i]['iduser']);
            $contratos[$i]['iduser'] = $ususario->email;


            if($contratos[$i]['estado']== 1 ){
                $contratos[$i]['estado']= 'activo';
            }else{
                $contratos[$i]['estado']='finalizado';
            }
        }
        return view('contratos.index', compact('contratos'));
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $personas = Persona::all();
        $usuarios = DB::table('users')
        ->leftJoin('contratos', 'users.id', '=', 'contratos.iduser')
        ->whereNull('contratos.id')
        ->select('users.*')
        ->get();

        return view('contratos.crear', compact('personas','usuarios'));
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
            'detalle' => 'required',
            'f_ini' => 'required',
            'f_fin' => 'required',
            'idpersonal' => 'required',
            'iduser' => ['required'],
        ]);


        Contrato::create($request->all());


        return redirect()->route('contratos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function show(Contrato $contrato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $contrato = Contrato::find($id);

        $personas = Persona::all();
        $usuarios = User::all();


        return view('contratos.editar', compact('contrato','personas','usuarios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'detalle' => 'required',
            'f_ini' => 'required',
            'f_fin' => 'required',
            'idpersonal' => 'required',
            'iduser' => ['required'],
            'estado' => ['required'],
        ]);

        $input = $request->all();

        $contrato =Contrato::find($id);
        $contrato -> update($input);

        return redirect()->route('contratos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $contrato =Contrato::find($id);
        Contrato::find($id)->delete();



        return redirect()->route('contratos.index');
    }


}
