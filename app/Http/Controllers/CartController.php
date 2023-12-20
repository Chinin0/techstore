<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Categoria;


class CartController extends Controller
{
    public function shop()
    {

        $categories = Categoria::all();
        $products = Producto::all(); // Puedes modificar esta lógica según las categorías seleccionadas

        return view('carrito.shop')->withTitle('E-COMMERCE STORE | SHOP')->with(['products' => $products,'categories' => $categories]);
    }

    public function filtrar(Request $request)
    {
        $categories = Categoria::all();
        $categoriaSeleccionada = $request->input('categoria');

        if ($categoriaSeleccionada) {
            $products = Producto::where('idcategoria', $categoriaSeleccionada)->get();
        } else {
            $products = Producto::all();
        }

        return view('carrito.shop')->withTitle('E-COMMERCE STORE | SHOP')->with(['products' => $products,'categories' => $categories]);;
    }

    public function cart()  {
        $cartCollection = \Cart::session(auth()->id())->getContent();
        //dd($cartCollection);
        return view('carrito.cart')->withTitle('E-COMMERCE STORE | CART')->with(['cartCollection' => $cartCollection]);;
    }
    public function remove(Request $request){
        \Cart::session(auth()->id())->remove($request->id);
        return redirect()->route('cart.index')->with('success_msg', 'Item eliminado!');
    }

    public function add(Request$request){
        \Cart::session(auth()->id())->add(array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->img,
            )
        ));
        return redirect()->route('cart.index')->with('success_msg', 'Item Agregado a sú Carrito!');
    }

    public function update(Request $request){
        \Cart::session(auth()->id())->update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
        ));

        return redirect()->route('cart.index')->with('success_msg', 'El carrito se actualizo!');
    }

    public function clear(){
        \Cart::session(auth()->id())->clear();
        return redirect()->route('cart.index')->with('success_msg', 'El carrito esta limpio!');
    }

}
