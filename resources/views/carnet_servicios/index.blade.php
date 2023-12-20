@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Paciente</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        @can('crear-paciente')
                            <a class="btn btn-warning" href="{{ route('carnet_servicio.create') }}"> Nuevo </a>
                        @endcan

                            {!! Form::open(array('route'=>'carnet_servicios.ver', 'method'=>'POST', 'enctype'=>'multipart/form-data')) !!}
                            <table id="data-table" class = "table table-striped mt-2">
                                <thead >
                                    <th> ID</th>
                                    <th> Nombre</th>
                                    <th> especie</th>
                                    <th> raza</th>
                                    <th> sexo</th>
                                    <th> color</th>
                                    <th> f_nacimiento</th>
                                    <th> propietario</th>
                                    <th> perfil</th>
                                    <th> Cartet </th>
                                    <th> Accion</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $paciente->id }}</td>
                                        <td>{{ $paciente->nombre }}</td>
                                        <td>{{ $paciente->especie }}</td>
                                        <td>{{ $paciente->raza }}</td>
                                        <td>{{ $paciente->sexo }}</td>
                                        <td>{{ $paciente->color }}</td>
                                        <td>{{ $paciente->f_nacimiento }}</td>
                                        <td>
                                            {{ $propietario->nombre.' '.$propietario->app_apm }}

                                        </td>
                                        <td>    <img 
                                                    class="navbar-brand-full app-header-logo" 
                                                    src="{{asset($paciente->perfil)}}" 
                                                    width="65"
                                                    alt="Infyom Logo">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            {!! Form::close() !!}

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

