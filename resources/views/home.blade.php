@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1 class="page__heading">Dashboard de Ventas</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <canvas id="ventasPorProductos" width="400" height="400"></canvas>
                            </div>
                            <div class="col-md-8">
                                <canvas id="evolucionVentas" width="400" height="200"></canvas>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

        // Obtener los datos para los gráficos desde el controlador
        var ventasPorProductosData = {!! json_encode($ventasPorProductosData) !!};
        const evolucionVentas = {!! json_encode($evolucionVentasData) !!};

        // Configurar y renderizar el gráfico de ventas por productos
        var ventasPorProductosCtx = document.getElementById('ventasPorProductos').getContext('2d');
        var ventasPorProductosChart = new Chart(ventasPorProductosCtx, {
            type: 'pie',
            data: {
                labels: ventasPorProductosData.productos,
                datasets: [{
                    data: ventasPorProductosData.ventas,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        // ...
                    ],
                }]
            },
            options: {
                // Puedes configurar opciones adicionales para el gráfico aquí
            }
        });

        // Configurar y renderizar el gráfico de evolución de ventas por días
        var evolucionVentasCtx = document.getElementById('evolucionVentas').getContext('2d');
        var evolucionVentasChart = new Chart(evolucionVentasCtx, {
            type: 'line',
            data: {
                labels: evolucionVentas.dias,
                datasets: [{
                    label: 'Evolución de Ventas',
                    data: evolucionVentas.ventas,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Fecha'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Ventas'
                        }
                    }
                }
            }
        });

    </script>
@endsection


