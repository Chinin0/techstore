@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">tipo de servicio</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        @can('crear-tipo_servicio')
                            <a class="btn btn-warning" href="{{ route('tipo_servicios.create') }}"> Nuevo </a>
                        @endcan


                            <table id="data-table" class = "table table-striped mt-2">
                                <thead >
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Detalle</th>
                                    <th>Costo</th>
                                    <th> Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach($tiposServicios as $tiposServicio)
                                    <tr>
                                        <td>{{ $tiposServicio->id }}</td>
                                        <td>{{ $tiposServicio->servicio }}</td>
                                        <td>{{ $tiposServicio->detalle }}</td>
                                        <td>{{ $tiposServicio->costo }}</td>
                                        <td>
                                        @can('editar-tipo_servicio')
                                            <a class = "btn btn-info" href="{{ route('tipo_servicios.edit',$tiposServicio->id) }}"> Editar </a>
                                        @endcan

                                        @can('borrar-tipo_servicio')
                                            {!! Form::open(['method' => 'DELETE','route' => ['tipo_servicios.destroy', $tiposServicio->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('borrar', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $tiposServicios->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

