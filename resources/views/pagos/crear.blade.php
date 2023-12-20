@extends('layouts.tienda')


@section('content')

<div class="container" style="margin-top: 80px">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Pagar mi pedido</div>

                <div class="card-body">
                    <p>¡Confirma tu compra!</p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{  $product->price * $product->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">Total</td>
                                <td>{{ $total }}</td>
                            </tr>
                        </tfoot>
                    </table>

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

                    <form method="POST" action="{{ route('servicioqr.consumir') }}" target="QrImage" id="qrForm">
                        @csrf
                        <h4>Datos de Cliente</h4>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Nombres</label>
                                <input type="text" name="tcRazonSocial" placeholder="Nombre del Usuario" value="{{ old('tcRazonSocial') }}">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">CI/NIT</label>
                                <input type="text" name="tcCiNit" placeholder="Número de CI/NIT" value="{{ old('tcCiNit') }}">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Celular</label>
                                <input type="text" name="tnTelefono" placeholder="Número de Teléfono" value="{{ old('tnTelefono') }}">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Correo</label>
                                <input type="text" name="tcCorreo" placeholder="Correo Electrónico" value="{{ old('tcCorreo') }}">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Monto Total</label>
                                <input  type="text" name="tnMonto" placeholder="Costo Total" value="{{ $total}}" readonly>
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Tipo de Servicio</label>
                                <select name="tnTipoServicio" class="form-control">
                                    <option value="1">Servicio QR</option>
                                    {{-- <option value="2">Tigo Money</option> --}}
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="form-group" style="margin-top: 20px; text-align: right;">
                            <button type="submit" class="btn btn-primary" style="text-align: right;">Generar QR</button>
                            <a href="{{route('listaPagos')}}" class="btn btn-success">Procesar Pago</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="col-12 py-5">
                <div class="row d-flex justify-content-center">
                    <iframe name="QrImage" style="width: 100%; height: 495px;"></iframe>
                </div>
            </div>
        </div>

    </div>

</div>
<script>
$("#qrForm").on("submit", function() {

$("#modal").modal("show");

});

$('iframe[name="QrImage"]').on('load', function() {
 $("#modal").modal("hide");
});
</script>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Generando QR</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Cargando...</span>
            </div>
          </div>
          <p class="text-center mt-3">Generando QR, por favor espere...</p>
        </div>
      </div>
    </div>
  </div>
@endsection
