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
                            <a class="btn btn-warning" href="{{ route('pacientes.create') }}"> Nuevo </a>
                        @endcan
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
                                    @foreach($pacientes as $paciente)
                                    <tr>
                                        <td>{{ $paciente->id }}</td>
                                        <td>{{ $paciente->nombre }}</td>
                                        <td>{{ $paciente->especie }}</td>
                                        <td>{{ $paciente->raza }}</td>
                                        <td>{{ $paciente->sexo }}</td>
                                        <td>{{ $paciente->color }}</td>
                                        <td>{{ $paciente->f_nacimiento }}</td>
                                        <td>
                                            @foreach($propietarios as $propietario)
                                                @if($propietario->id == $paciente->propietario)
                                                    {{ $propietario->nombre.' '.$propietario->app_apm }}
                                                @endif
                                            @endforeach

                                        </td>
                                        <td>    <img 
                                                    class="navbar-brand-full app-header-logo" 
                                                    src="{{asset($paciente->perfil)}}" 
                                                    width="65"
                                                    alt="Infyom Logo">
                                        </td>
                                        <td>
                                            <a class = "btn btn-info" href="{{ route('carnet_servicios.edit',$paciente->id ) }}"> Ver </a>
                                        </td>
                                        <td>
                                        @can('editar-paciente')
                                            <a class = "btn btn-info" href="{{ route('pacientes.edit',$paciente->id) }}"> Editar </a>
                                        @endcan

                                        @can('borrar-paciente')
                                            {!! Form::open(['method' => 'DELETE','route' => ['pacientes.destroy', $paciente->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('borrar', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $pacientes->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

