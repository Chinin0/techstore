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
                                    <strong>¡Revise los campos!</strong>
                                    @foreach ($errors->all() as $error)
                                        <span class="badge badge-danger">{{ $error }}</span>
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            {!! Form::model($ingreso, ['route' => ['ingresos.update', $ingreso->id], 'method' => 'PATCH']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="idproveedor">Cliente</label>
                                        <select name="idproveedor" id="idproveedor" class="form-control" required>
                                            <option value="">Seleccionar Proveedor</option>
                                            @foreach ($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}" {{ $proveedor->id == $ingreso->idcliente ? 'selected' : '' }}>
                                                    {{ $proveedor->nombre }}
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
                                            @foreach ($detalles as $detalle)
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
                                                        <input type="number" name="precio[]" class="form-control" value="{{ $detalle->precio }}"
                                                            min="0" required>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr id="fila-vacia">
                                                <td>
                                                    <input type="text" id="producto" name="productos[]" list="productos">

                                                    <datalist id="productos">
                                                        @foreach ($productos as $producto)
                                                            <option value="{{ $producto->id . ' ' . $producto->codigo . ' ' . $producto->nombre }}">{{ $producto->descripcion }}</option>
                                                        @endforeach
                                                    </datalist>
                                                </td>
                                                <td>
                                                    <input type="number" name="cantidad[]" class="form-control" value="1" min="1" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="precio[]" class="form-control" value="0" min="0" required>
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
                                            <option value="sin comprobante" {{ $ingreso->tipo_comprobante == 'sin comprobante' ? 'selected' : '' }}>
                                                Sin Comprobante</option>
                                            <option value="nota de ingreso" {{ $ingreso->tipo_comprobante == 'nota de ingreso' ? 'selected' : '' }}>
                                                NOTA DE VENTA</option>
                                            <option value="recibo" {{ $ingreso->tipo_comprobante == 'recibo' ? 'selected' : '' }}>Recibo</option>
                                            <option value="proforma" {{ $ingreso->tipo_comprobante == 'proforma' ? 'selected' : '' }}>Pro-Forma
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="serie_comprobante">Serie de Comprobante:</label>
                                        <input type="text" name="serie_comprobante" id="serie_comprobante"
                                            value="{{ $ingreso->serie_comprobante }}">
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="num_comprobante">Número de Comprobante:</label>
                                        <input type="text" name="num_comprobante" id="num_comprobante"
                                            value="{{ $ingreso->num_comprobante }}">
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
@endsection
