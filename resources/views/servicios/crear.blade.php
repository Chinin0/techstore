@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading"></h3>
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

                            {!! Form::open(array('route'=>'servicios.store', 'method'=>'POST')) !!}
                            <div class="row">


                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="idmedico">Medico Veterinario</label>
                                        <input type="text" id="idmedico" name="idmedico" list="idmedicos" class="form-control">

                                        <datalist id="idmedicos">
                                            @foreach ($medicos as $medico)
                                                <option value="{{ $medico->id }}">{{ $medico->nombre }}</option>
                                            @endforeach
                                        </datalist>

                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="idpaciente">Paciente</label>
                                        <input type="text" id="idpaciente" name="idpaciente" list="idpacientes" class="form-control">

                                        <datalist id="idpacientes">
                                            @foreach ($pacientes as $paciente)
                                                <option value="{{ $paciente->id }}">{{ $paciente->nombre }}</option>
                                            @endforeach
                                        </datalist>

                                    </div>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="responsable">Responsable</label>
                                        <input type="text" id="responsable" name="responsable" list="responsables" class="form-control">

                                        <datalist id="responsables">
                                            @foreach ($personas as $persona)
                                                <option value="{{ $persona->nombre.'  '.$persona->apellido }}"></option>
                                            @endforeach
                                        </datalist>

                                    </div>
                                </div>

                                <h3>Servicios de Control</h3>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <table class="table" id="tabla-dinamica">
                                        <thead>
                                            <tr>
                                                <th>Servicio</th>
                                                <th>Precio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr id="fila-vacia">
                                                    <td>
                                                        <input type="text" id="servicio" name="servicio[]" list="servicios">

                                                        <datalist id="servicios">
                                                            @foreach($tiposervicios as $tiposervicio)
                                                                <option value="{{ $tiposervicio->id.' '.$tiposervicio->servicio.' '.$tiposervicio->detalle }}"></option>
                                                            @endforeach
                                                        </datalist>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="precio[]" class="form-control" value="0" >
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-grid gap-2 col-6 mx-aut">
                                    <button onclick="agregarFila()">Agregar Fila</button>
                                </div>

                                <h3>Atencion Clinica</h3>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="motivo">Motivo</label>
                                        <input type="text" id="motivo" name="motivo" class="form-control">
                                    </div>
                                </div>




                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <table class="table" id="tabla-dinamica-atencion">
                                        <thead>
                                            <tr>
                                                <th>Procedimiento</th>
                                                <th>Costo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr id="fila-vacia-2">
                                                    <td>
                                                        <input type="text" id="atencion" name="atencion[]" >
                                                    </td>
                                                    <td>
                                                        <input type="number" name="costo[]" class="form-control" value="0" >
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-grid gap-2 col-6 mx-aut">
                                    <button onclick="agregarFila2()">Agregar Fila</button>
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

        function agregarFila2() {
            var tabla = document.getElementById("tabla-dinamica-atencion");
            var filaVacia = document.getElementById("fila-vacia-2");

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
