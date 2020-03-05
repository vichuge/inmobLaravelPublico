@if(session('id')==null)
<script>
    window.location = "{{URL::to('/')}}/login";
</script>
@endif

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />

    <link rel="icon" href="{{URL::to('/')}}@include('admin.raiz')/assets/images/favicon.ico">

    <title>{{config('app.name','Laravel')}}</title>
    
    <link rel="stylesheet"
        href="{{URL::to('/')}}@include('admin.raiz')/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="{{URL::to('/')}}@include('admin.raiz')/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="{{URL::to('/')}}@include('admin.raiz')/assets/css/bootstrap.css">
    <link rel="stylesheet" href="{{URL::to('/')}}@include('admin.raiz')/assets/css/neon-core.css">
    <link rel="stylesheet" href="{{URL::to('/')}}@include('admin.raiz')/assets/css/neon-theme.css">
    <link rel="stylesheet" href="{{URL::to('/')}}@include('admin.raiz')/assets/css/neon-forms.css">
    <link rel="stylesheet" href="{{URL::to('/')}}@include('admin.raiz')/assets/css/custom.css">

    <!-- Table dataTable -->
    <link rel="stylesheet" href="{{URL::to('/')}}@include('admin.raiz')/assets/js/datatables/datatables.css">
    <link rel="stylesheet" href="{{URL::to('/')}}@include('admin.raiz')/assets/js/select2/select2-bootstrap.css">
    <link rel="stylesheet" href="{{URL::to('/')}}@include('admin.raiz')/assets/js/select2/select2.css">

    <!-- Gallery single -->
    <link rel="stylesheet" href="{{URL::to('/')}}@include('admin.raiz')/assets/js/jcrop/jquery.Jcrop.min.css">
    <link rel="stylesheet" href="{{URL::to('/')}}@include('admin.raiz')/assets/js/dropzone/dropzone.css">

    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/jquery-1.11.3.min.js"></script>
    <!--<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
    </script>-->

    <!-- Tiny MCE-->
    <script
        src="http://cloud.tinymce.com/stable/tinymce.min.js?apiKey=4gv5xp1pjca7nt4fzf54zv0m8f54sms0ojgwmqi866a9s7lr">
    </script>

    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--Estadisticas -->
    <link type="text/css" rel="stylesheet"
        href="{{URL::to('/')}}@include('admin.raiz')/assets/js/rickshaw/rickshaw.min.css">
    <script src="{{URL::to('/')}}@include('admin.raiz')/rickshaw/vendor/d3.min.js"></script>
    <script src="{{URL::to('/')}}@include('admin.raiz')/rickshaw/vendor/d3.layout.min.js"></script>
    <script src="{{URL::to('/')}}@include('admin.raiz')/rickshaw/rickshaw.min.js"></script>

    <!-- Mi estilo-->
    <!--<script src="{{URL::to('/')}}/css/style.css"></script>-->

    <style>
        .page-body .page-container .sidebar-menu{
            background: #b83472;
        }
        .page-container .sidebar-menu #main-menu li {
            border-bottom: 1px solid #efb6b5;
        }
        .page-container .sidebar-menu #main-menu li ul > li > a {
            background-color: #b83472;
            padding-left: 40px;
        }
        .page-container .sidebar-menu #main-menu li a {
            color: #efb6b5;
        }
        .page-container .sidebar-menu #main-menu li ul {
            border-top: 1px solid #efb6b5;
        }
        .page-container .sidebar-menu #main-menu li ul > li {
            border-bottom: 1px solid #efb6b5; 
        }
        .page-container .sidebar-menu .logo-env > div.sidebar-collapse a, .page-container .sidebar-menu .logo-env > div.sidebar-mobile-menu a {
            border: 1px solid #efb6b5;
        }
        .page-container .sidebar-menu .logo-env > div > a {
            color: #efb6b5;
        }
        .page-container .sidebar-menu #main-menu li ul > li > a:hover {
            background-color: #953a69;
        }
        .page-container.sidebar-collapsed .sidebar-menu #main-menu > li > a > span:not(.badge) {
            background: #953a69;
        }
        .page-container .sidebar-menu #main-menu li.has-sub > a:before {
            color: #efb6b5;
        }
    </style>

@yield('mapstyle')


</head>

<body class="page-body" >
    <div class="page-container">
        <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

        <!-- Barra de navegación-->
        <div class="sidebar-menu" >
            <div class="sidebar-menu-inner">
                <header class="logo-env">
                    <!-- logo -->
                    <div class="logo">
                        <a href="index.php">
                            <img src="{{URL::to('/')}}@include('admin.raiz')/assets/images/logo@2x.png" width="160"
                                alt="" />
                        </a>
                    </div>
                    <!-- logo collapse icon -->
                    <div class="sidebar-collapse">
                        <a href="#" class="sidebar-collapse-icon">
                            <!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                            <i class="entypo-menu"></i>
                        </a>
                    </div>
                    <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                    <div class="sidebar-mobile-menu visible-xs">
                        <a href="#" class="with-animation">
                            <!-- add class "with-animation" to support animation -->
                            <i class="entypo-menu"></i>
                        </a>
                    </div>
                </header>
                <ul id="main-menu" class="main-menu">
                    <!-- add class "multiple-expanded" to allow multiple submenus to open -->
                    <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
                    <li>
                        <!-- <a href="index.php" target="_blank">-->
                        <a href="{{url('/')}}">
                            <i class="entypo-monitor"></i>
                            <span class="title">Inicio</span>
                        </a>
                    </li>
                    <li class="has-sub">
                        <a href="">
                            <i class="entypo-mail"></i>
                            <span class="title">Configuración</span>
                            <!--<span class="badge badge-secondary">8</span>-->
                        </a>
                        <ul>
                            @if(session('idrol')==4)
                            <li>
                                <a href="{{url('amenidades')}}">
                                    <i class="entypo-inbox"></i>
                                    <span class="title">Amenidades</span>
                                </a>
                            </li>
                            @endif

                            <li>
                                <a href="{{url('colonias')}}">
                                    <i class="entypo-pencil"></i>
                                    <span class="title">Colonias</span>
                                </a>
                            </li>
                            @if(session('idrol')==1)
                            <li>
                                <a href="{{url('agentes')}}">
                                    <i class="entypo-attach"></i>
                                    <span class="title">Agentes</span>
                                </a>
                            </li>
                            @endif
                            <li>
                                <a href="{{url('mapa_negocios')}}">
                                    <i class="entypo-attach"></i>
                                    <span class="title">Mapa de negocios</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="opened active has-sub">-->
                    <li>
                        <a href="{{url('propiedades')}}">
                            <i class="entypo-monitor"></i>
                            <span class="title">Propiedades</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="entypo-bag"></i>
                            <span class="title">Contenidos</span>
                            <!--<span class="badge badge-info badge-roundless">New Items</span>-->
                        </a>
                        <!--<ul class="visible">-->
                        <ul>
                            <!--<li class="has-sub">-->
                            <li>
                                <a href={{url('blogs')}}>
                                    <span class="title">Blog</span>
                                    <!--<span class="badge badge-success">3</span>-->
                                </a>
                            </li>
                            <li>
                                <a href={{url('faqs')}}>
                                    <span class="title">FAQs</span>
                                </a>
                            </li>
                            <li>
                                <a href={{url('testimonios')}}>
                                    <span class="title">Testimonios</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href={{url('prospectos')}}>
                            <i class="entypo-monitor"></i>
                            <span class="title">Prospectos</span>
                        </a>
                    </li>
                    @if(session('idrol')==1)
                    <li>
                        <a href={{url('usuarios')}}>
                            <i class="entypo-monitor"></i>
                            <span class="title">Usuarios</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="main-content">

            <!-- Barra de usuario-->
            <div class="row">

                <!-- Profile Info and Notifications -->
                <div class="col-md-6 col-sm-8 clearfix">

                    <ul class="user-info pull-left pull-none-xsm">

                    </ul>

                    <ul class="user-info pull-left pull-right-xs pull-none-xsm">

                    </ul>

                </div>


                <!-- Raw Links -->
                <div class="col-md-6 col-sm-4 clearfix hidden-xs">

                    <ul class="list-inline links-list pull-right">

                        <!-- Profile Info -->
                        <li class="profile-info dropdown">
                            <!-- add class "pull-right" if you want to place this from right -->

                            <p class="dropdown-toggle">
                                <img src="{{session('imagen')!=null?asset('storage').'/'.session('imagen'):asset('storage').'/uploads/'.'user.jpg'}}"
                                    alt="" class="img-circle" height="30" />
                                {{session('nomagente')}} {{session('apeagente')}}
                            </p>

                        </li>
                        <!-- Language Selector -->
                        <li class="dropdown language-selector">

                        </li>

                        <li class="sep"></li>

                        <li>
                            <a href="{{url('logout')}}">
                                Log Out <i class="entypo-logout right"></i>
                            </a>
                        </li>
                    </ul>

                </div>

            </div>
            <hr>

            <!-- Aqui comienza todo-->
            @yield('content')
            <!-- Aqui termina-->
            <br />
            <!-- lets do some work here... -->
            <!-- Footer -->
            <footer class="main">
                <!--&copy; 2015 <strong>Neon</strong> Admin Theme by <a href="http://laborator.co" target="_blank">Laborator</a>-->
                Todos los derechos reservados 2019
            </footer>
        </div>
    </div>
    <!-- Bottom scripts (common) -->
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/gsap/TweenMax.min.js"></script>
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js">
    </script>
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/bootstrap.js"></script>
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/joinable.js"></script>
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/resizeable.js"></script>
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/neon-api.js"></script>

    <!-- Gallery single -->
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/jcrop/jquery.Jcrop.min.js"></script>
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/dropzone/dropzone.js"></script>
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/neon-chat.js"></script>

    <!-- Data table -->
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/datatables/datatables.js"></script>
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/select2/select2.min.js"></script>
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/neon-chat.js"></script>

    <!-- Login-->
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/jquery.validate.min.js"></script>
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/neon-login.js"></script>


    <!-- JavaScripts initializations and stuff -->
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="{{URL::to('/')}}@include('admin.raiz')/assets/js/neon-demo.js"></script>

</body>

</html>