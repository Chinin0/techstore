@extends('layouts.tienda')
<style>
/* Estilos generales */
body {
  font-family: Arial, sans-serif;
  color: #333;
}

/* Estilos para la sección */
.section {
  max-width: 800px;
  margin: 80px auto;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.section-header {
  display: flex;
  align-items: center;
  margin-bottom: 25px;
}

.page__heading {
  font-size: 28px;
  margin: 0;
  margin-right: auto;
}

/* Estilos para la tabla */
.table {
  background-color: #fff;
  border-collapse: collapse;
}

.table thead {
  background-color: #e06161;
  color: #fff;
}

.table th,
.table td {
  padding: 12px 15px;
  border: 1px solid #ddd;
}

.table tbody tr:nth-child(even) {
  background-color: #f3f3f3;
}

/* Estilos paginación */
.pagination {
  display: flex;
  padding: 10px 15px;
  border-top: 1px solid #ddd;
}

.page-link {
  color: #333;
  padding: 5px 10px;
  border: 1px solid #ddd;
  border-radius: 3px;
}

.page-link:hover {
  background: #55608f;
  color: #fff;
  border-color: #55608f;
}
</style>
@section('content')
    <section class="section" >
        <div class="section-header">
            <h3 class="page__heading">Estado de Pagos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            @if(count($pagos) > 0)
                                <table id="data-table" class="table table-striped mt-2">
                                    <thead>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                        @foreach($pagos as $pago)
                                            <tr>
                                                <th>{{ $pago->id }}</th>
                                                <th>{{ $pago->nombre }}</th>
                                                <th>{{ $pago->fecha }}</th>
                                                <th>{{ $pago->monto }}</th>
                                                <th>{{ $pago->estado_pago }}</th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination justify-content-end">
                                    {!! $pagos->links() !!}
                                </div>
                            @else
                                <p>No hay pagos para mostrar.</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

