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

                            {!! Form::open(array('route'=>'ingresos.store', 'method'=>'POST')) !!}
                            <div class="row">


                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="idproveedor">Proveedor</label>
                                        <input type="text" id="idproveedor" name="idproveedor" list="idproveedores" class="form-control">

                                        <datalist id="idproveedores">
                                            @foreach ($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
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
                                                <th>Precio</th>
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
                                                        <input type="number" name="precio[]" class="form-control" value="1" min="1" required>
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
                                        <label for="tipo_comprobante">tipo de comprobante </label>
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
                                        <label for="serie_comprobante">Serie de Comprobante:</label>
                                        <input type="text" name="serie_comprobante" id="serie_comprobante">
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


@endsection
