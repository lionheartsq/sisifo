<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li @click="menu=0" class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-speedometer"></i> <b>Escritorio</b></a>
            </li>
            {{--
            <li class="nav-title" style="color:#00dfa3">
                Mantenimiento
            </li>
            --}}
            {{-- @endif
            @if(Auth::user()->vistas['administracion']) --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-settings"></i> <b>Administración</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=36" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Configuración</a>
                    </li>
                    <li @click="menu=23" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Areas</a>
                    </li>
                    <li @click="menu=24" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Procesos</a>
                    </li>
                    <li @click="menu=25" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Perfiles</a>
                    </li>
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Empresa</a>
                    </li>
                    <li @click="menu=11" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Tipo Factura</a>
                    </li>
                    <li @click="menu=16" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Impuestos</a>
                    </li>
                    <li @click="menu=17" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Medidas</a>
                    </li>
                </ul>
            </li>
            {{-- @endif --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wrench"></i> <b>Reportes</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Ciudades</a>
                    </li>
                    <li @click="menu=10" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Departamentos</a>
                    </li>
                    <li @click="menu=19" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Reservas</a>
                    </li>
                    <li @click="menu=20" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Habitación</a>
                    </li>
                    <li @click="menu=21" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Ocupación</a>
                    </li>
                    <li @click="menu=22" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Tipo</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wrench"></i> <b>Facturación</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=15" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Grupos</a>
                    </li>
                    <li @click="menu=13" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Pedidos</a>
                    </li>
                    <li @click="menu=9" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Cobros</a>
                    </li>
                    <li @click="menu=12" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Pagos</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> <b>Contabilidad</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Facturar</a>
                    </li>
                    <li @click="menu=8" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Asientos</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-settings"></i> <b>Control ingreso</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=6" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Ingreso y salida</a>
                    </li>
                </ul>
            </li>

            {{-- @if(Auth::user()->vistas['documentacion']) --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-settings"></i> <b>Documentación</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=43" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Manual de usuario versión pdf</a>
                    </li>
                    <li @click="menu=44" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Cartilla práctica de costos versión pdf</a>
                    </li>
                    <li @click="menu=45" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Cartilla práctica de costos versión digital</a>
                    </li>
                    <li @click="menu=46" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Video Tutoriales</a>
                    </li>
                </ul>
            </li>
            {{-- @if(Auth::user()->vistas['conceptosCif']) --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-folder"></i> <b>Conceptos cif</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=31" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-folder-alt"></i> Conceptos</a>
                    </li>
                    <li @click="menu=32" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-folder-alt"></i> Maquinaria</a>
                    </li>
                </ul>
            </li>
            {{-- @endif
            @if(Auth::user()->vistas['materiales']) --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wrench"></i> <b>Materiales</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=26" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Unidades</a>
                    </li>
                    <li @click="menu=27" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Clasificación</a>
                    </li>
                    <li @click="menu=28" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Materias primas</a>
                    </li>
                </ul>
            </li>
            {{-- @endif
            @if(Auth::user()->vistas['productos']) --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> <b>Productos</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=29" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Catálogos</a>
                    </li>
                    <li @click="menu=14" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Productos</a>
                    </li>
                    <li @click="menu=30" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Hojas de costo</a>
                    </li>
                    <li @click="menu=37" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Simulador</a>
                    </li>
                </ul>
            </li>
            {{-- @endif
            @if(Auth::user()->vistas['produccion']) --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-docs"></i> <b>Producción</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=38" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-doc"></i> Cotización</a>
                    </li>
                    <li @click="menu=39" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-doc"></i> Orden de pedido</a>
                    </li>
                </ul>
            </li>
            {{-- @endif
            @if(Auth::user()->vistas['kardex']) --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-folder-alt"></i> <b>Kárdex</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=40" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-note"></i> Kárdex almacén</a>
                    </li>
                    <li @click="menu=42" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-note"></i> Toma inventario</a>
                    </li>
                    <li @click="menu=41" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-note"></i> Kárdex producto</a>
                    </li>
                </ul>
            </li>
           {{-- @endif
            @if(Auth::user()->vistas['manoDeObra']) --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-folder-alt"></i> <b>Mano de Obra</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=47" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-note"></i> Tiempo Estandar</a>
                    </li>
                </ul>
            </li>
            {{-- @endif
            @if(Auth::user()->vistas['personas']) --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user"></i> <b>Personas</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=33" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-pencil"></i> Roles</a>
                    </li>
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-pencil"></i> Usuarios</a>
                    </li>
                    <li @click="menu=7" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Proveedores</a>
                    </li>
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Clientes</a>
                    </li>
                    <li @click="menu=18" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Empleados</a>
                    </li>
                </ul>
            </li>
            {{-- @endif
            @if(Auth::user()->vistas['nomina']) --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-settings"></i> <b>Nómina</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=48" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Vinculación</a>
                    </li>
                    <li @click="menu=49" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Gestionar nómina</a>
                    </li>
                </ul>
            </li>
            {{-- @endif
            @if(Auth::user()->vistas['gestionFinanciera']) --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> <b>Gestión financiera</b></a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=50" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Precio de venta</a>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> <b>Punto de equilibrio</b></a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=51" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Punto de equilibrio individual</a>
                            </li>
                            <li @click="menu=56" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Punto de equilibrio multiproducto</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> <b>Indicadores financieros</b></a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=53" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Liquidez</a>
                            </li>
                            <li @click="menu=52" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Endeudamiento</a>
                            </li>
                            <li @click="menu=57" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Rentabilidad</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i> <b>Actividades o gestión</b></a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=54" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Rotación inventario</a>
                            </li>
                            <li @click="menu=55" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Rotación cartera</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            {{-- @endif --}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>


