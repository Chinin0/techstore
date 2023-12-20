<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Pago;
use App\Models\Venta;
use App\Models\DetalleVenta;

class ConsumirServicioController extends Controller
{
    public function guardarCarrito($numero_referencia,$pagoId){
        //buscar y asociar a su pago

        // Crear una nueva venta
        $venta = Venta::create([
            'idPago' => $pagoId,
            'idusuario' => auth()->id(),
            'tipo_comprobante'=> 'NOTA DE VENTA',
            'num_comprobante'=> $numero_referencia,
            'fecha_hora'=> now() ,
            'impuesto'=> 0,
            'total' => 0, // Se actualizará más adelante
            'estado' => 'Pendiente',
        ]);
         $carrito = \Cart::session(auth()->id())->getContent();
        // Calcular el total de la venta y crear los detalles de venta
        $totalVenta = 0;
         foreach ($carrito as $item) {

            $cantidad = $item->quantity;
            $precio = $item->price;
            $descuento = 0;

            $subtotal = $precio * $cantidad;
            $totalVenta += ($subtotal - $descuento);

            DetalleVenta::create([
                'idventa' => $venta->id,
                'idproducto' => $item->id,
                'cantidad' => $cantidad,
                'precio' => $precio,
                'descuento' => $descuento,
            ]);

/*             // Actualizar el stock del producto
            $producto->stock -= $cantidad;
            $producto->save(); */
        }

        // Actualizar el total de la venta
        $venta->impuesto = $totalVenta *0 ;
        // Actualizar el total de la venta
        $venta->total = $totalVenta ;
        $venta->estado ="Pendiente" ;
        $venta->save();

    }
    public function RecolectarDatos(Request $request)
    {

        $this->validate($request, [
            'tcRazonSocial' => 'required|string',
            'tcCiNit' => 'required|string',
            'tnTelefono' => 'required|string',
            'tcCorreo' => 'required|email',
            'tnMonto' => 'required|numeric',
        ]);

        try {
            $lcComerceID           = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $lnMoneda              = 2;
            $lnTelefono            = $request->tnTelefono;
            $lcNombreUsuario       = $request->tcRazonSocial;
            $lnCiNit               = $request->tcCiNit;
            $lcNroPago             = "test-grupo27sa" . rand(100000, 999999);
            $lnMontoClienteEmpresa = $request->tnMonto;
            $lcCorreo              = $request->tcCorreo;
            $lcUrlCallBack         = "https://mail.tecnoweb.org.bo/inf513/grupo27sa/libreria/public/api/confirmarPago/";
            $lcUrlReturn           = "http://localhost:8000/";


            $laPedidoDetalle       = [];
            $carrito = \Cart::session(auth()->id())->getContent();//obtenemos el carrito

            $indice = 0;
            foreach ($carrito as  $producto) {
                $laPedidoDetalle[$indice]['Serial']    = $producto['id']; // Ajusta según la estructura real de tu carrito
                $laPedidoDetalle[$indice]['Producto']  = $producto['name']; // Ajusta según la estructura real de tu carrito
                $laPedidoDetalle[$indice]['Cantidad']  = $producto['quantity']; // Ajusta según la estructura real de tu carrito
                $laPedidoDetalle[$indice]['Precio']  = $producto['price']; // Ajusta según la estructura real de tu carrito
                $laPedidoDetalle[$indice]['Descuento']  = 0; // Ajusta según la estructura real de tu carrito
                $laPedidoDetalle[$indice]['Total']  = $producto['price']*$producto['quantity']; // Ajusta según la estructura real de tu carrito
                $indice++;
            }

            $lcUrl                 = "";

            $loClient = new Client();

            if ($request->tnTipoServicio == 1) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            } elseif ($request->tnTipoServicio == 2) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/realizarpagotigomoneyv2";
            }

            $laHeader = [
                'Accept' => 'application/json'
            ];

            $laBody   = [
                "tcCommerceID"          => $lcComerceID,
                "tnMoneda"              => $lnMoneda,
                "tnTelefono"            => $lnTelefono,
                'tcNombreUsuario'       => $lcNombreUsuario,
                'tnCiNit'               => $lnCiNit,
                'tcNroPago'             => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo"              => $lcCorreo,
                'tcUrlCallBack'         => $lcUrlCallBack,
                "tcUrlReturn"           => $lcUrlReturn,
                'taPedidoDetalle'       => $laPedidoDetalle
            ];

            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);

            $laResult = json_decode($loResponse->getBody()->getContents());

            if ($request->tnTipoServicio == 1) {

                //CREAMOS PAGO EN ESTADO PENDIENTE
                $pago = Pago::create([
                    'iduser' => auth()->id(),
                    'nombre' => $lcNombreUsuario,
                    'numero_referencia' => $lcNroPago ,
                    'monto' => $lnMontoClienteEmpresa,
                    'descripcion' => $lnMontoClienteEmpresa,
                    'metodo_pago' => 'Pago QR',
                    'fecha' => now(),
                    'estado_pago' => 'Pendiente',
                ]);
                //Creamos la Venta en estado Pendiente
                $this->guardarCarrito($lcNroPago,$pago->id);
                //limpiamos el carrito
                \Cart::session(auth()->id())->clear();

                $laValues = explode(";", $laResult->values)[1];

                $laQrImage = "data:image/png;base64," . json_decode($laValues)->qrImage;
                echo '<img src="' . $laQrImage . '" alt="Imagen base64" width="100%" height="auto">';
            }
        } catch (\Throwable $th) {

            return $th->getMessage() . " - " . $th->getLine();
        }
    }

    public function ConsultarEstado(Request $request)
    {
        $lnTransaccion = $request->tnTransaccion;

        $loClientEstado = new Client();

        $lcUrlEstadoTransaccion = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/consultartransaccion";

        $laHeaderEstadoTransaccion = [
            'Accept' => 'application/json'
        ];

        $laBodyEstadoTransaccion = [
            "TransaccionDePago" => $lnTransaccion
        ];

        $loEstadoTransaccion = $loClientEstado->post($lcUrlEstadoTransaccion, [
            'headers' => $laHeaderEstadoTransaccion,
            'json' => $laBodyEstadoTransaccion
        ]);

        $laResultEstadoTransaccion = json_decode($loEstadoTransaccion->getBody()->getContents());

        $texto = '<h5 class="text-center mb-4">Estado Transacción: ' . $laResultEstadoTransaccion->values->messageEstado . '</h5><br>';

        return response()->json(['message' => $texto]);
    }

    public function urlCallback(Request $request)
    {
        $Venta = $request->input("PedidoID");
        $Fecha = $request->input("Fecha");
        $NuevaFecha = date("Y-m-d", strtotime($Fecha));
        $Hora = $request->input("Hora");
        $MetodoPago = $request->input("MetodoPago");
        $Estado = $request->input("Estado");
        $Ingreso = true;

        try {
            $arreglo = ['error' => 0, 'status' => 1, 'message' => "Pago realizado correctamente.", 'values' => true];
        } catch (\Throwable $th) {
            $arreglo = ['error' => 1, 'status' => 1, 'messageSistema' => "[TRY/CATCH] " . $th->getMessage(), 'message' => "No se pudo realizar el pago, por favor intente de nuevo.", 'values' => false];
        }

        return response()->json($arreglo);
    }


}
