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
        <h1>Detalles del Servicio</h1>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <h3>Información del Servicio</h3>
                <p><strong>ID:</strong> {{ $servicio->id }}</p>
                <p><strong>Responsable:</strong> {{ $servicio->responsable }}</p>
                <p><strong>Paciente:</strong> {{ $servicio->idpaciente }}</p>
                <p><strong>Medico:</strong> {{ $servicio->idmedico }}</p>
                <p><strong>Fecha y Hora:</strong> {{ $servicio->fecha }}</p>
                <p><strong>Total:</strong> {{ $servicio->total }}</p>
            </div>

            <div class="col-md-6">
                <h3>Detalles del Servicio</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Costo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->nro_servicio }}</td>
                                <td>{{ $detalle->costo }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($det_atencion)
                    <h3>Atencion Clinica : {{ $atencion->id }}</h3>
                    <p><strong>Motivo:</strong> {{ $atencion->motivo }}</p>                    <table class="table">
                        <thead>
                            <tr>
                                <th>Procedimineto</th>
                                <th>Costo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($det_atencion as $detalleA)
                                <tr>
                                    <td>{{ $detalleA->detalle_procedimiento }}</td>
                                    <td>{{ $detalleA->costo }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @endif

            </div>


        </div>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

