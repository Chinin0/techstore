@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Servicios</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        @can('crear-servicio')
                            <a class="btn btn-warning" href="{{ route('servicios.create') }}"> Nuevo </a>
                        @endcan


                            <table id="data-table" class = "table table-striped mt-2">
                                <thead >
                                    <th>ID</th>
                                    <th>Medico</th>
                                    <th>Paciente</th>
                                    <th>Total</th>
                                    <th>Detalle</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach($servicios as $servicio)
                                    <tr>
                                        <th>{{ $servicio->id }}</th>
                                        <th>{{ $servicio->idmedico }}</th>
                                        <th>{{ $servicio->idpaciente }}</th>
                                        <th>{{ $servicio->total }}</th>
                                        <th>
                                            <a href="{{ route('servicios.show', $servicio->id) }}" class="btn btn-info">Ver</a>
                                        </th>
                                        <td>
                                        @can('editar-servicio')
                                            <a class = "btn btn-info" href="{{ route('servicios.edit',$servicio->id) }}"> Editar </a>
                                        @endcan

                                        @can('borrar-servicio')
                                            {!! Form::open(['method' => 'DELETE','route' => ['servicios.destroy', $servicio->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('borrar', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $servicios->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

