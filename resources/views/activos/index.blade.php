@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Activos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        @can('crear-activo')
                            <a class="btn btn-warning" href="{{ route('activos.create') }}"> Nuevo </a>
                        @endcan


                            <table id="data-table" class = "table table-striped mt-2">
                                <thead >
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Detalle</th>
                                    <th>Mantenimineto</th>
                                    <th>Estado</th>
                                    <th> Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach($activos as $activo)
                                    <tr>
                                        <td>{{ $activo->id }}</td>
                                        <td>{{ $activo->nombre }}</td>
                                        <td>{{ $activo->detalle }}</td>
                                        <td>{{ $activo->f_mantenimiento }}</td>
                                        <td>{{ $activo->estado }}</td>
                                        <td>
                                        @can('editar-activo')
                                            <a class = "btn btn-info" href="{{ route('activos.edit',$activo->id) }}"> Editar </a>
                                        @endcan

                                        @can('borrar-activo')
                                            {!! Form::open(['method' => 'DELETE','route' => ['activos.destroy', $activo->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('borrar', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $activos->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

