@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Alta de Personas</h3>
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

                            {!! Form::open(array('route'=>'ventas.store', 'method'=>'POST')) !!}
                            <div class="row">


                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="idcliente">Cliente</label>
                                        <input type="text"  name="idcliente" list="listaClientes" class="form-control">

                                        <datalist id="listaClientes">
                                            @foreach ($clientes as $cliente)
                                                <option value="{{ $cliente->id }}">{{ $cliente->nombre.'  '.$cliente->apellido }}</option>
                                            @endforeach
                                        </datalist>
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
                                <div class="d-grid gap-2 col-6 mx-aut">
                                    <button onclick="agregarFila()">Agregar Fila</button>
                                </div>



                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="idcliente">tipo de comprobante </label>
                                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control" required>
                                            <option value="sin comprobante">sin comprobante</option>
                                            <option value="nota de venta">NOTA DE VENTA</option>
                                            <option value="recibo">Recibo</option>
                                            <option value="proforma">Pro-Forma</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="num_comprobante">Numero de Comprobante:</label>
                                        <input type="text" name="num_comprobante" id="num_comprobante">
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
