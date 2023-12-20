@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Nuevo Contrato</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        @can('crear-contrato')
                            <a class="btn btn-warning" href="{{ route('contratos.create') }}"> Nuevo </a>
                        @endcan


                            <table id="data-table" class = "table table-striped mt-2">
                                <thead >
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Detalle</th>
                                    <th>Estado</th>
                                    <th>Fecha inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach($contratos as $contrato)
                                    <tr>
                                        <th>{{ $contrato->id }}</th>
                                        <th>{{ $contrato->idpersonal }}</th>
                                        <th>{{ $contrato->iduser }}</th>
                                        <th>{{ $contrato->detalle }}</th>
                                        <th>{{ $contrato->estado }}</th>
                                        <th>{{ $contrato->f_fin }}</th>
                                        <th>{{ $contrato->f_fin }}</th>
                                        <td>
                                        @can('editar-contrato')
                                            <a class = "btn btn-info" href="{{ route('contratos.edit',$contrato->id) }}"> Editar </a>
                                        @endcan

                                        @can('borrar-contrato')
                                            {!! Form::open(['method' => 'DELETE','route' => ['contratos.destroy', $contrato->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('borrar', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $contratos->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

