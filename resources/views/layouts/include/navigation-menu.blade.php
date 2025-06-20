<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <x-nav.heading>Inicio</x-nav.heading>
                <x-nav.nav-link content='Panel' icon="fas fa-tachometer-alt" :href="route('panel')"/>

                <x-nav.heading>Modulos</x-nav.heading> 

                <!----Compras---->
                @can('ver-compra')
                <x-nav.link-collapsed
                    id="collapseCompras"
                    icon="fa-solid fa-store"
                    content="Compras"> 
                    @can('ver-compra')
                    <x-nav.link-collapsed-item href="{{ route('compras.index') }}" content="Ver" />
                    @endcan
                    @can('crear-compra')
                    <x-nav.link-collapsed-item href="{{ route('compras.create') }}" content="Crear" />
                    @endcan
                </x-nav.link-collapsed>
                @endcan

                <!----Ventas---->
                @can('ver-venta')
                <x-nav.link-collapsed
                    id="collapseVentas"
                    icon="fa-solid fa-cart-shopping"
                    content="Ventas">
                    @can('ver-venta')
                    <x-nav.link-collapsed-item href="{{ route('ventas.index') }}" content="Ver" />
                    @endcan
                    @can('crear-venta')
                    <x-nav.link-collapsed-item href="{{ route('ventas.create') }}" content="Crear" />
                    @endcan
                </x-nav.link-collapsed>
                @endcan

                <!---- Categorias ---->
                @can('ver-categoria')
                <x-nav.nav-link content='Categorías' icon="fa-solid fa-tag" :href="route('categorias.index')"/>
                @endcan

                <!----Presentaciones---->
                @can('ver-presentacione')
                <x-nav.nav-link content='Presentaciones' icon="fa-solid fa-box-archive" :href="route('presentaciones.index')"/>
                @endcan

                <!----Marcas---->
                @can('ver-marca')
                <x-nav.nav-link content='Marcas' icon="fa-solid fa-bullhorn" :href="route('marcas.index')"/>
                @endcan

                <!----Productos---->
                @can('ver-producto')
                <x-nav.nav-link content='Productos' icon="fa-brands fa-shopify" :href="route('productos.index')"/>
                @endcan

                <!----Inventario---->
                <x-nav.nav-link content='Inventario' icon="fa-solid fa-box" :href="route('inventario.index')"/>

                <!----Kardex---->
                <x-nav.nav-link content='Kardex' icon="fa-solid fa-file" :href="route('kardex.index')"/>

                <!----Clientes---->
                @can('ver-cliente')
                <x-nav.nav-link content='Clientes' icon="fa-solid fa-users" :href="route('clientes.index')"/>
                @endcan

                <!----Proveedores---->
                @can('ver-proveedore')
                <x-nav.nav-link content='Proveedores' icon="fa-solid fa-user-group" :href="route('proveedores.index')"/>
                @endcan

                <x-nav.heading>Otros</x-nav.heading>

                <!----Usuarios---->
                @can('ver-user')
                <x-nav.nav-link content='Usuarios' icon="fa-solid fa-user" :href="route('users.index')"/>
                @endcan

                <!----Roles---->
                @can('ver-role')
                <x-nav.nav-link content='Roles' icon="fa-solid fa-person-circle-plus" :href="route('roles.index')"/>
                @endcan
                
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Bienvenido:</div>
            {{ auth()->user()->name }}
        </div>
    </nav>
</div>