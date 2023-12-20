@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ingreso de Mercaderia</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        @can('crear-ingreso')
                            <a class="btn btn-warning" href="{{ route('ingresos.create') }}"> Nuevo </a>
                        @endcan


                            <table id="data-table" class = "table table-striped mt-2">
                                <thead >
                                    <th>ID</th>
                                    <th>Proveedor</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach($ingresos as $ingreso)
                                    <tr>
                                        <th>{{ $ingreso->id }}</th>
                                        <th>{{ $ingreso->idproveedor }}</th>
                                        <th>{{ $ingreso->fecha }}</th>
                                        <th>{{ $ingreso->total }}</th>
                                        <th>{{ $ingreso->estado }}</th>
                                        <td>
                                        <a href="{{ route('ingresos.show', $ingreso->id) }}" class="btn btn-info">Ver</a>

                                        @can('editar-ingreso')
                                            <a class = "btn btn-info" href="{{ route('ingresos.edit',$ingreso->id) }}"> Editar </a>
                                        @endcan

                                        @can('borrar-ingreso')
                                            {!! Form::open(['method' => 'DELETE','route' => ['ingresos.destroy', $ingreso->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('borrar', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $ingresos->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

