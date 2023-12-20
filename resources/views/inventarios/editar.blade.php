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

                            {!! Form::model($inventario, ['method' => 'PUT','route' => ['inventarios.update', $inventario->id]]) !!}
                            <div class="row">


                            <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="idactivo">Activo</label>
                                        <input type="text" id="idactivo" name="idactivo" list="activos" class="form-control">
                                        <datalist id="activos">
                                            @foreach ($activos as $activo)
                                                <option value="{{ $activo->id }}">{{ $activo->nombre }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="idproducto">Producto</label>
                                        <input type="text" id="idproducto" name="idproducto" list="productos" class="form-control">
                                        <datalist id="productos">
                                            @foreach($productos as $producto)
                                                <option value="{{ $producto->id }}">{{ $producto->id.' '.$producto->codigo.' '.$producto->nombre.' '.$producto->descripcion }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="detalle">Detalle</label>
                                        {!! Form::text('detalle',null,array('class'=>'form-control')) !!}
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

