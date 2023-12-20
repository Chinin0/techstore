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

                            {!! Form::model($contrato, ['route' => ['contratos.update', $contrato->id], 'method' => 'PATCH']) !!}
                            <div class="row">



                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="idpersonal">persona</label>
                                        <input type="text" id="idpersonal" name="idpersonal" list="idpersonas" class="form-control">

                                        <datalist id="idpersonas">
                                            @foreach ($personas as $persona)
                                                <option value="{{ $persona->id }}">{{ $persona->nombre }}</option>
                                            @endforeach
                                        </datalist>

                                    </div>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="iduser">Usuario</label>
                                        <input type="text" id="iduser" name="iduser" list="usuarios" class="form-control">

                                        <datalist id="usuarios">
                                            @foreach ($usuarios as $usuario)
                                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                            @endforeach
                                        </datalist>

                                    </div>
                                </div>



                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="detalle">Detalle del contrato</label>
                                        <select name="detalle" id="detalle" class="form-control" required>
                                            <option value="Peluquero">Peluquero</option>
                                            <option value="Medico Veterinario">Medico Veterinario</option>
                                            <option value="Contador">Contador</option>
                                            <option value="Proveedor">Proveedor</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="f_ini">Fecha Inicio del Contrato</label>
                                        <input type="date" name="f_ini" id="f_ini">
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="f_fin">Fecha de Finalizacion del Contrato</label>
                                        <input type="date" name="f_fin" id="f_fin">
                                    </div>
                                </div>



                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="estado">Estado del contrato</label>
                                        <select name="estado" id="estado" class="form-control" required>
                                            <option value="1" {{ $contrato->estado === 'Activo' ? 'selected' : '' }}>Activo</option>
                                            <option value="0" {{ $contrato->estado === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        </select>
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
