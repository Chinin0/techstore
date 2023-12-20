<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Persona;



use App\Models\TipoServicio;
use App\Models\DetalleAtencion;
use App\Models\AtencionClinica;
use App\Models\Servicio;
use App\Models\DetalleServicio;

class CarnetServicioController extends Controller
{
    //carnet_servicios

    function _construct(){
        $this->middleware('permission:ver-carnet_servicio|crear-user|editar-user|borrar-user', ['only'=>['index']]);
        $this->middleware('permission:crear-carnet_servicio', ['only'=>['create','store']]);
        $this->middleware('permission:editar-carnet_servicio', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-carnet_servicio', ['only'=>['destroy']]);
    }
    public function ver(  $id)
    {
        return $id;
        $paciente = Paciente::find($id);
        $propietario = Persona::find($paciente->prorpietario);
       return view('carnet_servicios.index', compact('pacientes','propietario'));
     }

    public function index($id)
    {
        return $id;
        $paciente = Paciente::find($id);
        $propietario = Persona::find($paciente->prorpietario);
       return view('carnet_servicios.index', compact('pacientes','propietario'));
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
        $propietario = Persona::find($paciente->propietario);
        $paciente['propietario'] = $propietario->nombre.' '.$propietario->app_apm;

        $controles = DetalleServicio::select('detalle_servicios.*','servicios.idmedico')
        ->leftJoin('servicios', 'detalle_servicios.idservicio', '=', 'servicios.id')
        ->leftJoin('tipo_servicios', 'tipo_servicios.id', '=', 'detalle_servicios.nro_servicio')
        ->where( 'detalle_servicios.tipo_servicio', '=', 'Control')
        ->where( 'servicios.idpaciente', '=', $paciente->id)
        ->where( 'tipo_servicios.servicio', '!=', 'Desparacitacion')
        ->where( 'tipo_servicios.servicio', '!=', 'Vacuna Antiravica')
        ->orderBy('detalle_servicios.created_at', 'desc')
        ->get();
        for ($i = 0; $i < count($controles); $i++) {
            $persona = Persona::find($controles[$i]['idmedico']);
            $controles[$i]['idmedico'] = $persona->nombre.' '.$persona->app_apm;


            $tipo = TipoServicio::find($controles[$i]['nro_servicio']);
            $controles[$i]['nro_servicio'] = $tipo->servicio;
        }


        $desparacitaciones = DetalleServicio::select('detalle_servicios.*','servicios.idmedico')
        ->leftJoin('servicios', 'detalle_servicios.idservicio', '=', 'servicios.id')
        ->leftJoin('tipo_servicios', 'tipo_servicios.id', '=', 'detalle_servicios.nro_servicio')
        ->where( 'detalle_servicios.tipo_servicio', '=', 'Control')
        ->where( 'servicios.idpaciente', '=', $paciente->id)
        ->where( 'tipo_servicios.servicio', '=', 'Desparacitacion')
        ->orderBy('detalle_servicios.created_at', 'desc')
        ->get();
        for ($i = 0; $i < count($desparacitaciones); $i++) {
            $persona = Persona::find($desparacitaciones[$i]['idmedico']);
            $desparacitaciones[$i]['idmedico'] = $persona->nombre.' '.$persona->app_apm;


            $tipo = TipoServicio::find($desparacitaciones[$i]['nro_servicio']);
            $desparacitaciones[$i]['nro_servicio'] = $tipo->servicio;
        }


        $antiravicas = DetalleServicio::select('detalle_servicios.*','servicios.idmedico')
        ->leftJoin('servicios', 'detalle_servicios.idservicio', '=', 'servicios.id')
        ->leftJoin('tipo_servicios', 'tipo_servicios.id', '=', 'detalle_servicios.nro_servicio')
        ->where( 'detalle_servicios.tipo_servicio', '=', 'Control')
        ->where( 'servicios.idpaciente', '=', $paciente->id)
        ->where( 'tipo_servicios.servicio', '=', 'Vacuna Antiravica')
        ->orderBy('detalle_servicios.created_at', 'desc')
        ->get();

        for ($i = 0; $i < count($antiravicas); $i++) {
            $persona = Persona::find($antiravicas[$i]['idmedico']);
            $antiravicas[$i]['idmedico'] = $persona->nombre.' '.$persona->app_apm;


            $tipo = TipoServicio::find($antiravicas[$i]['nro_servicio']);
            $antiravicas[$i]['nro_servicio'] = $tipo->servicio;
        }




        $reproducciones = DetalleServicio::select('detalle_servicios.*','servicios.idmedico')
        ->leftJoin('servicios', 'detalle_servicios.idservicio', '=', 'servicios.id')
        ->leftJoin('tipo_servicios', 'tipo_servicios.id', '=', 'detalle_servicios.nro_servicio')
        ->where( 'detalle_servicios.tipo_servicio', '=', 'Control')
        ->where( 'servicios.idpaciente', '=', $paciente->id)
        ->where( 'tipo_servicios.servicio', '=', 'Reproductivo')
        ->orderBy('detalle_servicios.created_at', 'desc')
        ->get();

        for ($i = 0; $i < count($reproducciones); $i++) {
            $persona = Persona::find($reproducciones[$i]['idmedico']);
            $reproducciones[$i]['idmedico'] = $persona->nombre.' '.$persona->app_apm;


            $tipo = TipoServicio::find($reproducciones[$i]['nro_servicio']);
            $reproducciones[$i]['nro_servicio'] = $tipo->servicio;
        }


        $atencions = AtencionClinica::select('atencion_clinica.*','detalle_servicios.costo','servicios.idmedico')
        ->leftJoin('detalle_servicios', 'detalle_servicios.nro_servicio', '=', 'atencion_clinica.id')
        ->leftJoin('servicios', 'detalle_servicios.idservicio', '=', 'servicios.id')
        ->where( 'detalle_servicios.tipo_servicio', '=', 'Atencion Clinica')
        ->where( 'servicios.idpaciente', '=', $paciente->id)
        ->orderBy('atencion_clinica.hr', 'desc')
        ->get();

        for ($i = 0; $i < count($atencions); $i++) {
            $persona = Persona::find($atencions[$i]['idmedico']);
            $atencions[$i]['idmedico'] = $persona->nombre.' '.$persona->app_apm;

        }


        //return $desparacitaciones;
        $detalles=DetalleAtencion::all();
        return view('carnet_servicios.editar', compact('paciente','detalles','reproducciones','atencions','desparacitaciones','controles','antiravicas'));
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



}
