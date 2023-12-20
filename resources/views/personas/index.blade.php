@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Proveedores</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        @can('crear-persona')
                            <a class="btn btn-warning" href="{{ route('personas.create') }}"> Nuevo </a>
                        @endcan


                            <table id="data-table" class = "table table-striped mt-2">
                                <thead >
                                    <th> ID</th>
                                    <th> Nombre</th>
                                    <th> Razon Social</th>
                                    {{-- <th> Sexo</th> --}}
                                    {{-- <th> Edad</th> --}}
                                    <th> Celular</th>
                                    <th> Direccion</th>
                                    <th> Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach($personas as $persona)
                                    <tr>
                                        <td>{{ $persona->id }}</td>
                                        <td>{{ $persona->nombre }}</td>
                                        <td>{{ $persona->app_apm }}</td>
                                        {{-- <td>{{ $persona->sexo }}</td> --}}

                                        {{-- <td>{{ $persona->f_nacimiento }}</td> --}}

                                        <td>{{ $persona->celular }}</td>
                                        <td>{{ $persona->direccion }}</td>
                                        <td>
                                        @can('editar-persona')
                                            <a class = "btn btn-info" href="{{ route('personas.edit',$persona->id) }}"> Editar </a>
                                        @endcan

                                        @can('borrar-persona')
                                            {!! Form::open(['method' => 'DELETE','route' => ['personas.destroy', $persona->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('borrar', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $personas->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

