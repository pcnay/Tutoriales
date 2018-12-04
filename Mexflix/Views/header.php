<!DOCTYPE html>
<html lang="es">
  <head>
    <meta name= "viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>MexFlix</title>
    <meta name = "description" content= "Bienvenidos a Mexflix Tus Peliculas y Series favoritas">
    <link rel= "shortcut icon" type ="image/png" href="./public/img/favicon.png">

    <!-- Libreria que ayuda a maquetar la parte del Frontend desarrollada por JhonMircha. -->
    <link rel = "stylesheet" href="./public/css/responsimple.css">
    <link rel = "stylesheet" href="./public/css/mexflix.css">


  </head>
  <body>
    <!-- Se inicia con el uso de la libreria "responsimple para las vistas-->
    <!-- Sección de Cabezera de la página, solo contendra "Logo" y "Menu de Navegación" -->
    <header class = "container center header">
    
      <!-- Con estas clases se ajuste para diferentes dispositivos, como celulares, tablets, Desktop, PC.-->
      <div class = "item i-b v-middle ph12 lg2 lg-left">
        <h1 class = "logo">Mexflix</h1>
      </div>
      <nav class = "item i-b v-middle ph12 lg10 menu lg-right ">
        <ul class = "container">
          <li class = "nobullet item inline"><a href="./">Inicio</a></li>
          <li class = "nobullet item inline"><a href="movieseries">MovieSeries </a></li>
          <li class = "nobullet item inline"><a href="users">Usuarios</a></li>
          <li class = "nobullet item inline"><a href="estatus">Estatus</a></li>
          <li class = "nobullet item inline"><a href="salir">Salir</a></li>
        </ul>
      </nav>

    </header>
    <!-- Sección principal de la página. -->
    <main class="container center main">
