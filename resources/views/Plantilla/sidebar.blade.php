<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
            <li class="nav-title">
                <i class="icon-home"></i> MENÚ
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> General</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=11" class="nav-item">
                        <a class="nav-link" href="#"><i class="	fa fa-tags fa-2x"></i> Categorias</a>
                    </li>
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-map-marker fa-2x"></i> Ciudades</a>
                    </li>
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-people"></i>Clientes</a>
                    </li>
                    <li @click="menu=3" class="nav-item">
                        {{-- <a class="nav-link" href="#"><i class="	fa fa-map-signs fa-2x"></i>Departamentos</a> --}}
                    </li>

                    <li @click="menu=7" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-tag"></i> Marcas</a>
                    </li>
                    <li @click="menu=8" class="nav-item">
                        <a class="nav-link" href="#"><i class="	fa fa-cubes fa-2x"></i> Productos</a>
                    </li>
                    <li @click="menu=9" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-handshake-o fa-2x"></i> Proveedores</a>
                    </li>
                    <li @click="menu=10" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cart-arrow-down fa-2x"></i> Salidas</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-user-plus"></i> Acceso</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-user-circle"></i>Usuarios</a>
                    </li>
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-group"></i>Roles</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-line-chart"></i> Facturas</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=6" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cart-arrow-down"></i> Ventas</a>
                    </li>
                    {{-- <li @click="menu=6" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cart-plus"></i> Ventas</a>
                    </li> --}}
                </ul>
            </li>

        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>

