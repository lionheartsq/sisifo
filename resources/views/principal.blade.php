<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Integral de Seguimiento Interno, Facturación y Organización">
    <meta name="author" content="Softclass">
    <meta name="keyword" content="Sistema Integral de Seguimiento Interno, Facturación y Organización">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>S.I.S.I.F.O</title>
    <!-- Icons -->
    <link href="css/simple-line-icons.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

    <div id="app"><!-- /Apertura div app que permite usar vue -->

        <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Escritorio</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Configuraciones</a>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    {{-- <img src="img/avatars/{{Auth::user()->id}}.jpg" class="img-avatar" alt="{{Auth::user()->email}}"> --}}
                    <img src="img/avatars/1.jpg" class="img-avatar" alt="{{Auth::user()->email}}">
                    <span class="d-md-down-none">{{Auth::user()->nombres}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>

                    <a class="dropdown-item" href="#" data-id="1" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-key"></i> Cambiar contraseña</a>

                    <a class="dropdown-item" href="{{route('logout')}}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Cerrar sesión</a>

                    <form id="logout-form" action="{{route('logout')}}" method="post" style="display: none;">
                    {{csrf_field()}}
                    </form>

                </div>
            </li>
            <li><p>&nbsp;&nbsp;&nbsp;</p></li>
        </ul>
    </header>

    <div class="app-body">


        @foreach (Auth::user()->roles as $rol)

            @if (($rol->id)==1)
                @include('contenido.sidebarsa')
            @elseif (($rol->id)==2)
                @include('contenido.sidebarem')
            @else
                @include('contenido.sidebarvacio')
            @endif

        @endforeach
       <!--
       @include('contenido.sidebarsa')
       -->

        <!-- Contenido Principal -->
        @yield('contenido')
        <!-- /Fin del contenido principal -->
    </div>

    </div><!-- /Cierre div app que permite usar vue -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('pass') }}">
                    @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cambiar contraseña</h4>
                </div>

                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-md-4 form-control-label" for="passnueva-input">Nueva clave</label>
                        <div class="col-md-8">
                            <input type="password" name="passnueva" id="passnueva" class="form-control" placeholder="Ingrese su nueva clave"/>
                            <input type="hidden" name="idusuarios" id="idusuarios" value="{{Auth::user()->idusuarios}}"/>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-primary" value="Guardar">
                </div>
            </form>
            </div><!-- modal content -->
        </div><!-- modal dialog -->
    </div><!-- modal fade -->
    <!-- Cierra Modal -->

    <footer class="app-footer">
        <span><a href="#">S.I.S.I.F.O</a> &copy; 2022</span>
        <span class="ml-auto">Desarrollado por <a href="#">SOFTCLASS</a></span>
    </footer>

    <!-- Bootstrap and necessary plugins -->
    <script src="js/app.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/pace.min.js"></script>
    <script src="js/template.js"></script>
    <script src="js/sweetalert2.all.js"></script>

</body>

</html>
