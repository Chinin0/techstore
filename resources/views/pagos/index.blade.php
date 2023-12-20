@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Pagos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        @can('crear-pago')
                            <a class="btn btn-warning" href="{{ route('pagos.create') }}"> Nuevo </a>
                        @endcan


                            <table id="data-table" class = "table table-striped mt-2">
                                <thead >
                                    <th>ID</th>
                                    <th>fecha</th>
                                    <th>nombre</th>
                                    <th>monto</th>
                                    <th>Metodo de Pago</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th> Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach($pagos as $pago)
                                    <tr>
                                        <td>{{ $pago->id }}</td>
                                        <td>{{ $pago->fecha }}</td>
                                        <td>{{ $pago->nombre }}</td>
                                        <td>{{ $pago->monto }}</td>
                                        <td>{{ $pago->metodo_pago }}</td>
                                        <td>{{ $pago->descripcion }}</td>
                                        <td>{{ $pago->estado_pago }}</td>
                                        <td>
                                        @can('borrar-pago')
                                            {!! Form::open(['method' => 'DELETE','route' => ['pagos.destroy', $pago->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('borrar', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $pagos->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

