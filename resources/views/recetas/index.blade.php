@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Recetas</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        @can('crear-venta')
                            <a class="btn btn-warning" href="{{ route('recetas.create') }}"> Nuevo </a>
                        @endcan


                            <table id="data-table" class = "table table-striped mt-2">
                                <thead >
                                    <th>ID</th>
                                    <th>Nro de Receta</th>
                                    <th>Medico</th>
                                    <th>Paciente</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach($recetas as $receta)
                                    <tr>
                                        <th>{{ $receta->id }}</th>
                                        <th>{{ $receta->numero_recetario }}</th>
                                        <th>{{ $receta->servicio->persona->nombre }}</th>
                                        <th>{{ $receta->servicio->paciente->nombre }}</th>
                                        <th>{{ $receta->estado }}</th>
                                        <td>
                                        <a href="{{ route('recetas.show', $receta->id) }}" class="btn btn-info">Ver</a>

                                        @can('borrar-venta')
                                            {!! Form::open(['method' => 'DELETE','route' => ['recetas.destroy', $receta->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('borrar', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $recetas->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

