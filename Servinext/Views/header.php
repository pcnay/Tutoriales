<?php 
  // Se oculta las opciones del menú hasta que el usuario inicie la sesión., por esta razón se agrega el parentesis antes de la etiqueta "nav".

  print(' 
      <!DOCTYPE html>
      <html lang="es">
        <head>
          <meta name= "viewport" content="width=device-width, initial-scale=1">
          <meta charset="UTF-8">
          <title>Control De SGI </title>
          <meta name = "description" content= "Bienvenidos a Control De SGI">
          <link rel= "shortcut icon" type ="image/png" href="./public/img/favicon.png">

          <!-- Libreria que ayuda a maquetar la parte del Frontend desarrollada por JhonMircha. -->
          <link rel = "stylesheet" href="./public/css/responsimple.css">
          <link rel = "stylesheet" href="./public/css/estilos.css">


        </head>
        <body>
          <!-- Se inicia con el uso de la libreria "responsimple para las vistas-->
          <!-- Sección de Cabezera de la página, solo contendra "Logo" y "Menu de Navegación" -->
          <header class = "container center header">
          
            <!-- Con estas clases se ajuste para diferentes dispositivos, como celulares, tablets, Desktop, PC.-->
            <div class = "item i-b v-middle ph12 lg2 lg-left">
              <h1 class = "logo">Control De SGI</h1>
            </div>
      ');
    if ($_SESSION['ok'])
    {
      print ('
          <nav class = "item i-b v-middle ph12 lg10 menu lg-right ">
            <ul class = "container">
              <li class = "nobullet item inline"><a href="./">Inicio</a></li>
              <li class = "nobullet item inline"><a href="inventarios">Inventarios</a></li>
              <li class = "nobullet item inline"><a href="sgi">SGI</a></li>
              <li class = "nobullet item inline"><a href="varios">Varios</a></li>
              <li class = "nobullet item inline"><a href="salir">Salir</a></li>
            </ul>
          </nav>
        ');
    }
    print('
      </header>
      <!-- Sección principal de la página. -->
      <main class="container center main">
    ');
