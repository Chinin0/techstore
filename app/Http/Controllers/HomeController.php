<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\TipoServicio;
use App\Models\DetalleServicio;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtener datos de ventas por productos
        $ventasPorProductos = Producto::select('productos.nombre', \DB::raw('SUM(detalle_ventas.cantidad) as total_ventas'))
            ->join('detalle_ventas', 'productos.id', '=', 'detalle_ventas.idproducto')
            ->groupBy('productos.nombre')
            ->orderBy('total_ventas', 'desc')
            ->get();

        $labelsProductos = [];
        $valuesProductos = [];

        foreach ($ventasPorProductos as $ventaProducto) {
            $labelsProductos[] = $ventaProducto->nombre;
            $valuesProductos[] = $ventaProducto->total_ventas;
        }

        // Obtener datos de evolución de las ventas por días
        $evolucionVentas = Venta::select(\DB::raw('DATE(fecha_hora) as fecha'), \DB::raw('SUM(detalle_ventas.cantidad) as total_ventas'))
            ->join('detalle_ventas', 'ventas.id', '=', 'detalle_ventas.idventa')
            ->groupBy(\DB::raw('DATE(fecha_hora)'))
            ->orderBy('fecha')
            ->get();

        $labelsDias = [];
        $valuesDias = [];

        foreach ($evolucionVentas as $venta) {
            $labelsDias[] = $venta->fecha;
            $valuesDias[] = $venta->total_ventas;
        }

        $ventasPorProductosData = [
            'productos' => $labelsProductos,
            'ventas' => $valuesProductos,
        ];

        $evolucionVentasData = [
            'dias' => $labelsDias,
            'ventas' => $valuesDias,
        ];

        return view('home', compact('ventasPorProductosData', 'evolucionVentasData'));
    }
}
