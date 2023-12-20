<li class="side-menus {{ Request::is('home') ? 'active' : '' }}">
  <li class="menu-header">Dashboard</li>

  <li>
    <a class="nav-link" href="{{route('home')}}">
      <i class=" fas fa-building"></i><span>Dashboard</span>
    </a>
  </li>

  <li class="menu-header">Gestion de Usuarios</li>
  <li class="dropdown">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-regular fa-users"></i> <span>Rol y Usuario</span></a>
    <ul class="dropdown-menu">
    <li>
     @can('ver-user')
      <a class="nav-link" href="{{route('usuarios.index')}}">
        <i class="fas fa-regular fa-user"></i><span>Usuarios</span>
      </a>
      @endcan
     </li>
      <li>
      @can('ver-rol')
        <a class="nav-link" href="{{route('roles.index')}}">
          <i class=" fas fa-user-lock"></i><span>Roles</span>
        </a>
      @endcan
      </li>
     </ul>
    <li>
    @can('ver-persona')
    <a class="nav-link" href="{{route('personas.index')}}">
        <i class=" fas fa-regular fa-child"></i><span>Proveedor</span>
    </a>
    @endcan
  </li>
    {{-- <li>
    @can('ver-paciente')
    <a class="nav-link" href="/pacientes">
        <i class=" fas fa-solid fa-paw"></i><span>Paciente</span>
    </a>
    @endcan
    </li> --}}
    {{-- <li>
    @can('ver-contrato')
    <a class="nav-link" href="/contratos">
        <i class=" fas fa-solid fa-id-card"></i><span>Contratos</span>
    </a>
    @endcan
    </li> --}}
    {{-- <li>
        @can('ver-blog')
            <a class="nav-link" href="/blogs">
            <i class="fas fa-blog"></i><span>Blog</span>
            </a>
        @endcan
    </li> --}}
</li>
<li class="menu-header">Pagos</li>

<li>
  @can('ver-pago')
    <a class="nav-link" href="{{route('pagos.index')}}">
      <i class=" fas fa-solid fa-money-bill-wave"></i><span>Pagos </span>
    </a>
  @endcan
</li>

{{-- <li class="menu-header">Servicios</li> --}}

{{-- <li>
  @can('ver-tipo_servicio')
    <a class="nav-link" href="/tipo_servicios">
      <i class=" fas fa-list-1-2"></i><span>Tipo de Servicios </span>
    </a>
  @endcan
</li> --}}

{{-- <li>
  @can('ver-servicio')
    <a class="nav-link" href="/servicios">
      <i class=" fas fa-bell-concierge"></i><span>Servicios </span>
    </a>
  @endcan
</li> --}}
{{--
<li>
  @can('ver-receta')
    <a class="nav-link" href="/recetas">
      <i class=" fas fa-solid fa-books-medical"></i><span>Recetas</span>
    </a>
  @endcan
</li> --}}

<li class="menu-header">Productos</li>
<li class="dropdown">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-solid fa-cube"></i> <span>Productos</span></a>
    <ul class="dropdown-menu">
    <li>
  @can('ver-categoria')
    <a class="nav-link" href="{{route('categorias.index')}}">
    <i class="fas fa-solid fa-list-ol"></i><span>Categoria</span>
    </a>
  @endcan
</li>

<li>
  @can('ver-producto')
    <a class="nav-link" href="{{route('productos.index')}}">
      <i class=" fas fa-cube"></i><span>Producto</span>
    </a>
  @endcan
  </li>

<li>
  @can('ver-activo')
    <a class="nav-link" href="{{route('activos.index')}}">
      <i class=" fas fa-solid fa-couch"></i><span>Bloque - Seccion</span>
    </a>
  @endcan
  </li>
     </ul>

<li>
  @can('ver-venta')
    <a class="nav-link" href="{{route('ventas.index')}}">
    <i class="fas fa-solid fa-cart-arrow-down"></i></i><span>Venta</span>
    </a>
  @endcan
  </li>

<li>
  @can('ver-ingreso')
    <a class="nav-link" href="{{route('ingresos.index')}}">
    <i class="fas fa-solid fa-truck-ramp-box fa-lg"></i><span>Ingreso</span>
    </a>
  @endcan
  </li>

<li class="menu-header">Almacen</li>


 <li>
  <a class="nav-link" href="{{route('inventarios.index')}}">
    <i class=" fas fa-blog"></i><span>Inventario</span>
  </a>
 </li>
</li>
<li class=" dropdown">
  <a data-toggle="dropdown">
    <i class=" fas fa-solid fa-palette"></i><span>Estilo</span>
  </a>

  <div class="dropdown-menu dropdown-menu-right">
    <div class="dropdown-title">
      Estilo de Pantalla </div>
    <a class="dropdown-item has-icon" href="{{route('estilo.normal')}}">
      <i class="fas fa-sun"></i>Normal</a>
    <a class="dropdown-item has-icon" href="{{route('estilo.light')}}">
    <i class="fas fa-solid fa-circle-half-stroke"></i></i> </i>Automatico</a>
    <a class="dropdown-item has-icon" href="{{route('estilo.dark')}}">
      <i class="fas fa-moon"></i> Dark
    </a>
  </div>
</li>
