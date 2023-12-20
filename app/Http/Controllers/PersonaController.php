<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



//agregamos
use Carbon\Carbon;
use App\Models\Persona;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{




    function _construct(){
        $this->middleware('permission:ver-persona|crear-persona|editar-persona|borrar-persona', ['only'=>['index']]);
        $this->middleware('permission:crear-persona', ['only'=>['create','store']]);
        $this->middleware('permission:editar-persona', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-persona', ['only'=>['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




     public function index()
     {
         //
         $date = Carbon::now();
         $personas = Persona::paginate(10);
         return view('personas.index', compact('personas','date'));
      }

     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
         //
         return view('personas.crear');
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
             'app_apm'=> 'required',
            //  'sexo'=> 'required',
            //  'f_nacimiento'=> 'required',
             'celular'=> 'nullable',
             'direccion'=> 'required'
         ]);

         $input = $request->all();

         $persona =Persona::create($input);


         return redirect()->route('personas.index');
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
         $persona = Persona::find($id);

         return view('personas.editar', compact('persona'));
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
            'app_apm'=> 'required',
            // 'sexo'=> 'required',
            // 'f_nacimiento'=> 'required',
            'celular'=> 'nullable',
            'direccion'=> 'required'
        ]);

             $input = $request->all();

             $persona =Persona::find($id);
             $persona -> update($input);


             return redirect()->route('personas.index');
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
         Persona::find($id)->delete();



         return redirect()->route('personas.index');
     }



 }
