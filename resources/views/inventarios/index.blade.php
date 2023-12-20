@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Inventario</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">

                                <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                        <h2>Productos agotados</h2>
                                        <ul class="list-group">
                                            @foreach ($faltantes as $producto)
                                                <li class="list-group-item">{{$producto->codigo.' '.$producto->nombre }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <h2>Productos con stock menor a 3 y mayores a 0:</h2>
                                        <ul class="list-group">
                                            @foreach ($excasos as $producto)
                                                <li class="list-group-item">{{ $producto->nombre }}</li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    @can('crear-inventario')
                                        <a class="btn btn-warning" href="{{ route('inventarios.create') }}"> Asignar Producto en Estante </a>
                                    @endcan







                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <h2>Productos ordenados por Activo:</h2>
                                        <table id="data-table" class = "table table-striped mt-2">
                                            <thead >
                                                <th>Activo</th>
                                                <th>Producto</th>
                                                <th>Ubicacion</th>
                                                <th> Acciones</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($inventarios as $inventario)
                                                <tr>
                                                    <td>{{ $inventario->idactivo }}</td>
                                                    <td>{{ $inventario->idproducto }}</td>
                                                    <td>{{ $inventario->detalle }}</td>
                                                    <td>
                                                    @can('editar-inventario')
                                                        <a class = "btn btn-info" href="{{ route('inventarios.edit',$inventario->id) }}"> Editar </a>
                                                    @endcan
                                                    @can('borrar-inventario')
                                                        {!! Form::open(['method' => 'DELETE','route' => ['inventarios.destroy', $inventario->id],'style'=>'display:inline']) !!}
                                                            {!! Form::submit('borrar', ['class'=>'btn btn-danger']) !!}
                                                        {!! Form::close() !!}
                                                    @endcan
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="pagination justify-content-end">
                                            {!! $inventarios->links() !!}
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection




