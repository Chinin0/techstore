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
        <h1>Detalles de la Venta</h1>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <h3>Información de la Venta</h3>
                <p><strong>ID:</strong> {{ $venta->id }}</p>
                <p><strong>Usuario:</strong> {{ $usuario }}</p>
                <p><strong>Tipo de Comprobante:</strong> {{ $venta->tipo_comprobante }}</p>
                <p><strong>Número de Comprobante:</strong> {{ $venta->num_comprobante }}</p>
                <p><strong>Fecha y Hora:</strong> {{ $venta->fecha_hora }}</p>
                <p><strong>Impuesto:</strong> {{ $venta->impuesto }}</p>
                <p><strong>Total:</strong> {{ $venta->total }}</p>
                <p><strong>Estado:</strong> {{ $venta->estado }}</p>
            </div>

            <div class="col-md-6">
                <h3>Detalles de la Venta</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Descuento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->idproducto }}</td>
                                <td>{{ $detalle->cantidad }}</td>
                                <td>{{ $detalle->precio }}</td>
                                <td>{{ $detalle->descuento }}</td>
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

