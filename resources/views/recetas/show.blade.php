@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ver</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                    <div class="container">
        <h1>Detalles de Receta</h1>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <h3>Información de la Venta</h3>
                <p><strong>ID:</strong> {{ $receta->id }}</p>
                <p><strong>Medico:</strong> {{ $receta->servicio->persona->nombre }}</p>
                <p><strong>Paciente:</strong> {{ $receta->servicio->paciente->nombre }}</p>
                <p><strong>Atencion:</strong> {{ 'Nro.: '.$receta->servicio->id.' Fecha: '.$receta->servicio->fecha }}</p>
                <p><strong>Estado:</strong> {{ $receta->estado }}</p>
            </div>

            <div class="col-md-6">
                <h3>Detalles de Receta</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Inidicaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->nombre_producto }}</td>
                                <td>{{ $detalle->indicaciones }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

