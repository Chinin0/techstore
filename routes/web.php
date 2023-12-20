<?php

use Illuminate\Support\Facades\Route;


//
//agregamos los controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CarnetServicioController;
use App\Http\Controllers\ContratoController;



use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ActivoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\TipoServicioController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ConsumirServicioController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
    //CARRITO

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware'=> ['auth']], function(){

    Route:: resource( 'roles', RolController::class);
    Route:: resource( 'usuarios', UsuarioController::class);
    Route:: resource( 'blogs', BlogController::class);
    Route:: resource( 'contratos', ContratoController::class);
    Route:: resource( 'personas', PersonaController::class);
    Route:: resource( 'pacientes', PacienteController::class);
    Route:: resource( 'carnet_servicios', CarnetServicioController::class);



    Route:: resource( 'categorias', CategoriaController::class);
    Route:: resource( 'productos', ProductoController::class);
    Route:: resource( 'activos', ActivoController::class);
    Route:: resource( 'ventas', VentaController::class);
    Route:: resource( 'ingresos', IngresoController::class);
    Route:: resource( 'inventarios', InventarioController::class);



    Route:: resource( 'tipo_servicios', TipoServicioController::class);
    Route:: resource( 'servicios', ServicioController::class);
    Route:: resource( 'pagos', PagoController::class);
    Route:: resource( 'recetas', RecetaController::class);



    Route::get('carnet/ver',  [UsuarioController::class, 'ver'])->name('ver');



    Route::get('estilo/light', [UsuarioController::class, 'light'])->name('estilo.light');
    Route::get('estilo/normal', [UsuarioController::class, 'normal'])->name('estilo.normal');
    Route::get('estilo/dark', [UsuarioController::class, 'dark'])->name('estilo.dark');

    Route::post('usuarios/editProfileForm', [UsuarioController::class, 'editProfileForm'])->name('usuarios.editProfileForm');
    Route::post('usuarios/changePasswordForm', [UsuarioController::class, 'changePasswordForm'])->name('usuarios.changePasswordForm');

    //Carrito
    Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.store');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/', [CartController::class, 'shop'])->name('shop');
    Route::get('/filtar', [CartController::class, 'filtrar'])->name('shop.filtrar');
    //servicios QR
    Route::post('/consumirServicio', [ConsumirServicioController::class, 'RecolectarDatos'])->name('servicioqr.consumir');
    Route::post('/consultar', [ConsumirServicioController::class, 'ConsultarEstado'])->name('servicioqr.consultar');

    Route::get('/listaCompras', [VentaController::class, 'VentasById'])->name('compras');
    Route::get('/listaPagos', [PagoController::class, 'PagosById'])->name('listaPagos');
});


