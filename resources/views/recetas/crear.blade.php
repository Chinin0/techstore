@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Alta de Recetas</h3>
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

                            {!! Form::open(array('route'=>'recetas.store', 'method'=>'POST')) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="idcliente">Numero Recetario</label>
                                        <input type="text"  name="numero_recetario"class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="idcliente">Servicio</label>
                                        <input type="text"  name="idatencion" list="listaServicio" class="form-control">

                                        <datalist id="listaServicio">
                                            @foreach ($servicios as $servicio)
                                                <option value="{{ $servicio->id.'  '.$servicio->fecha.''.$servicio->paciente->nombre }}">{{ $servicio->id.'  '.$servicio->fecha.''.$servicio->paciente->nombre }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <table class="table" id="tabla-dinamica">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Indicaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr id="fila-vacia">
                                                    <td>
                                                        <input type="text" id="producto" name="productos[]" list="productos">

                                                    </td>
                                                    <td>
                                                        <input type="text" name="indicaciones[]" class="form-control">
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-grid gap-2 col-6 mx-aut">
                                <a class = "btn btn-info"  onclick="agregarFila()">Agregar Fila</a>
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
