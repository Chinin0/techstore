<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



//agregamos 
use Carbon\Carbon;
use App\Models\Paciente;
use App\Models\Persona;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\Controller;
use App\Models\User;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;



class PacienteController extends Controller
{

    function _construct(){
        $this->middleware('permission:ver-paciente|crear-paciente|editar-paciente|borrar-paciente', ['only'=>['index']]);
        $this->middleware('permission:crear-paciente', ['only'=>['create','store']]);
        $this->middleware('permission:editar-paciente', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-paciente', ['only'=>['destroy']]);
    }



     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




     public function index()
     {
         //
        $pacientes = Paciente::paginate(10);
        $propietarios = Persona::all();
         return view('pacientes.index', compact('pacientes','propietarios'));
      }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
         //
            $propietarios = Persona::all();
         return view('pacientes.crear', compact('propietarios'));
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
             'especie'=> 'required',
             'raza'=> 'required',
             'sexo'=> 'required',
             'color'=> 'required',
             'f_nacimiento'=> 'nullable',
             'propietario'=> 'required',
            ]);
 
         $input = $request->all();

        $paciente =Paciente::create($input);
 
            
         return redirect()->route('pacientes.index');
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
     public function edit($id)
     {
         //
         $paciente = Paciente::find($id); 
         $propietarios = Persona::all();
         return view('pacientes.editar', compact('paciente','propietarios'));
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
         $this->validate($request, [
            'nombre'=> 'required',
            'especie'=> 'required',
            'raza'=> 'required',
            'sexo'=> 'required',
            'color'=> 'required',
            'f_nacimiento'=> 'nullable',
            'propietario'=> 'required',
            'perfil' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
       ]);
     
             $input = $request->all();

 
             $imageName = time().'.'.$request->perfil->extension();
             $image='img/perfil/'.Auth::user()->id.'/paciente/'.$imageName;                  
             $request->perfil->move(public_path('img/perfil/'.Auth::user()->id.'/paciente'), $imageName);
 
             $paciente =Paciente::find($id);
             $paciente -> update($input); 

             $paciente->perfil = $image;
             $paciente->save();
 

             return redirect()->route('pacientes.index');
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
//         $persona = Persona::find($id);
         Paciente::find($id)->delete();
 
 
 
         return redirect()->route('pacientes.index');
     }
 
 
    //



}
