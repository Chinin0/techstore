@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ventas</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        @can('crear-venta')
                            <a class="btn btn-warning" href="{{ route('ventas.create') }}"> Nuevo </a>
                        @endcan


                            <table id="data-table" class = "table table-striped mt-2">
                                <thead >
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach($ventas as $venta)
                                    <tr>
                                        <th>{{ $venta->id }}</th>
                                        <th>{{ $venta->idcliente }}</th>
                                        <th>{{ $venta->fecha_hora }}</th>
                                        <th>{{ $venta->total }}</th>
                                        <th>{{ $venta->estado }}</th>
                                        <td>
                                        <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-info">Ver</a>

                                        @can('editar-venta')
                                            <a class = "btn btn-info" href="{{ route('ventas.edit',$venta->id) }}"> Editar </a>
                                        @endcan

                                        @can('borrar-venta')
                                            {!! Form::open(['method' => 'DELETE','route' => ['ventas.destroy', $venta->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('borrar', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $ventas->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

