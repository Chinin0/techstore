@extends('layouts.tienda')

@section('content')
    <div class="container" style="margin-top: 80px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('shop')}}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tienda</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Productos</h4>
                    </div>
                </div>
                <hr>
                <form action="{{ route('shop.filtrar') }}" method="GET">
                    <div class="form-group">
                        <label for="categoria">Filtrar por categoría:</label>
                        <select class="form-control" id="categoria" name="categoria">
                            <option value="" selected>Todas las categorías</option>
                            @foreach($categories as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
                <div class="row">
                    @foreach($products as $producto)
                        <div class="col-lg-3">
                            <div class="card" style="margin-bottom: 20px; height: auto;">
                                <img src="{{asset( $producto->imagen) }}"
                                     class="card-img-top mx-auto"
                                     style="height: 150px; width: 150px;display: block;"
                                     alt="{{ $producto->imagen }}"
                                >
                                <div class="card-body">
                                    <a href=""><h6 class="card-title">{{ $producto->nombre }}</h6></a>
                                    <p>${{ $producto->precio_venta }}</p>
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $producto->id }}" id="id" name="id">
                                        <input type="hidden" value="{{ $producto->nombre }}" id="name" name="name">
                                        <input type="hidden" value="{{ $producto->precio_venta }}" id="price" name="price">
                                        <input type="hidden" value="{{ $producto->imagen }}" id="img" name="img">

                                        <input type="hidden" value="1" id="quantity" name="quantity">
                                        <div class="card-footer" style="background-color: white;">
                                              <div class="row">
                                                <button class="btn btn-secondary btn-sm" class="tooltip-test" title="add to cart">
                                                    <i class="fa fa-shopping-cart"></i> agregar al carrito
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
