@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
        <h3 class="page__heading">Editar</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>!Revise los campos!</strong>
                                    @foreach ($errors->all() as $error)
                                        <span class="badge badge-danger">{{$error}}</span>
                                    @endforeach
                                    <button type= "button" class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">$times;</span>
                                    </button>
                                </div>
                            @endif

                            {!! Form::model($venta, ['route' => ['ventas.update', $venta->id], 'method' => 'PATCH']) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="idcliente">Cliente</label>
            <select name="idcliente" id="idcliente" class="form-control" required>
                <option value="">Seleccionar Cliente</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $cliente->id == $venta->idcliente ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <table class="table" id="tabla-dinamica">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->detalleVentas as $detalle)
                    <tr>
                        <td>
                            <input type="text" name="productos[]" list="productos"
                                value="{{ $detalle->producto->id . ' ' . $detalle->producto->codigo . ' ' . $detalle->producto->nombre }}">
                            <datalist id="productos">
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id . ' ' . $producto->codigo . ' ' . $producto->nombre }}">
                                        {{ $producto->descripcion }}
                                    </option>
                                @endforeach
                            </datalist>
                        </td>
                        <td>
                            <input type="number" name="cantidad[]" class="form-control" value="{{ $detalle->cantidad }}"
                                min="1" required>
                        </td>
                        <td>
                            <input type="number" name="descuento[]" class="form-control" value="{{ $detalle->descuento }}"
                                min="0" required>
                        </td>
                    </tr>
                    @endforeach

                    <tr id="fila-vacia">
                        <td>
                            <input type="text" id="producto" name="productos[]" list="productos">

                            <datalist id="productos">
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id.' '.$producto->codigo.' '.$producto->nombre }}">{{ $producto->descripcion }}</option>
                                @endforeach
                            </datalist>
                        </td>
                        <td>
                            <input type="number" name="cantidad[]" class="form-control" value="1" min="1" required>
                        </td>
                        <td>
                            <input type="number" name="descuento[]" class="form-control" value="0" min="0" required>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>

    <div class="d-grid gap-2 col-6 mx-auto">
        <button onclick="agregarFila()">Agregar Fila</button>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="tipo_comprobante">Tipo de Comprobante</label>
            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control" required>
                <option value="sin comprobante" {{ $venta->tipo_comprobante == 'sin comprobante' ? 'selected' : '' }}>
                    Sin Comprobante</option>
                <option value="nota de venta" {{ $venta->tipo_comprobante == 'nota de venta' ? 'selected' : '' }}>
                    NOTA DE VENTA</option>
                <option value="recibo" {{ $venta->tipo_comprobante == 'recibo' ? 'selected' : '' }}>Recibo</option>
                <option value="proforma" {{ $venta->tipo_comprobante == 'proforma' ? 'selected' : '' }}>Pro-Forma
                </option>
            </select>
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <label for="serie_comprobante">Serie de Comprobante:</label>
            <input type="text" name="serie_comprobante" id="serie_comprobante"
                value="{{ $venta->serie_comprobante }}">
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <label for="num_comprobante">Número de Comprobante:</label>
            <input type="text" name="num_comprobante" id="num_comprobante"
                value="{{ $venta->num_comprobante }}">
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>
{!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection


@section('scripts')

<script>
        function agregarFila() {
            var tabla = document.getElementById("tabla-dinamica");
            var filaVacia = document.getElementById("fila-vacia");

            // Clonar la fila vacía
            var nuevaFila = filaVacia.cloneNode(true);

            // Limpiar los valores de los inputs en la nueva fila
            var inputs = nuevaFila.getElementsByTagName("input");
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = "";
            }

            // Agregar la nueva fila al final de la tabla
            tabla.getElementsByTagName("tbody")[0].appendChild(nuevaFila);
        }

    </script>



<script>
        function realizarBusqueda() {
            var searchTerm = document.getElementById('search-input').value;

            if (searchTerm.length >= 3) {
                axios.get('/productos/buscar', {
                    params: {
                        nombre: searchTerm
                    }
                })
                .then(function(response) {
                    var productos = response.data;
                    var resultsContainer = document.getElementById('search-results');

                    resultsContainer.innerHTML = '';

                    if (productos.length > 0) {
                        productos.forEach(function(producto) {
                            var productoElement = document.createElement('div');
                            productoElement.textContent = producto.nombre;
                            resultsContainer.appendChild(productoElement);
                        });
                    } else {
                        var noResultsElement = document.createElement('p');
                        noResultsElement.textContent = 'No se encontraron productos.';
                        resultsContainer.appendChild(noResultsElement);
                    }
                })
                .catch(function(error) {
                    console.error(error);
                });
            } else {
                document.getElementById('search-results').innerHTML = '';
            }
        }
    </script>

@endsection
