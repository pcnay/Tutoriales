<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Inventory System</title>

    <!--  Plugins de CSS -->

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Se agrega un icono para el tab de la aplicación.  -->
  <link rel="icon" href="vistas/img/plantilla/icono-negro.png">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">
  
  <!-- Theme style -->
  <!--- Se utilizara la version sin comprimir para poder realizar modificaciones mas adelane en el proyecto -->
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


    <!--  Plugins de JavaScript -->

    <!-- jQuery 3 -->
  <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>

  <!-- Bootstrap 3.3.7 -->
  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- SlimScroll , scroll oculto en los contenedores -->
  <script src="vistas/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  
  <!-- FastClick, mejora la interección en los diferentes dispositivos en que se utilizen.-->
  <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
  
  <!-- AdminLTE App, archivo de javascript base para la aplicacion de AdminLTE -->
  <script src="vistas/dist/js/adminlte.min.js"></script>
    
</head>


<!-- CUERPO DEL DOCUMENTO -->
<!-- sidebar-collapse = Para que el sidebar no se muestre al iniciar el menu, se muestra el icono de lineas para oprimirlo y se muestre -->
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
<!-- Site wrapper -->  


  <?php
    // Se valida si el usuario tiene sesión activada.
    if (isset($_SESSION["iniciarsesion"]) && $_SESSION["iniciarsesion"]=="ok")
    {
      echo '<div class = "wrapper">';
      include "dist/modulos/cabezote.php";
      include "dist/modulos/menu.php"; // Es el menu lateral Izq.  
      if (isset($_GET["ruta"]))
      {
        // Es la lista permitadas de las URL para la aplicación.
        if ($_GET["ruta"] == "inicio" || 
            $_GET["ruta"] == "usuarios" || 
            $_GET["ruta"] == "categorias" || 
            $_GET["ruta"] == "productos" || 
            $_GET["ruta"] == "clientes" || 
            $_GET["ruta"] == "ventas" || 
            $_GET["ruta"] == "crear-venta" || 
            $_GET["ruta"] == "reportes" )
          {
            include "dist/modulos/".$_GET["ruta"].".php";        
          }
        else
          {
            include "dist/modulos/404.php";
          }         

      }    
      else
      {
        // Para cuando no se tiene en la URL ruta definida, por defecto abre la de Inicio
        include "dist/modulos/inicio.php";
      } // if (isset($_GET["ruta"]))

      include "dist/modulos/footer.php";

      echo '</div>  ';
    }
    else // Se tiene que loguear para entrar al sistema.
    {
      include "dist/modulos/login.php";
    }

  ?>


<!-- Se guardan las funciones que se encuentran de JavaScript en los archivos del sistema POS -->
<script src="vistas/js/plantilla.js"></script>
</body>
</html>
