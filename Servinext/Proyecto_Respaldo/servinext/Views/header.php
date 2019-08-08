<?php 
	print ('
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<!-- Para manejar las pantallas de telefonos, Tablet -->
				<meta name= "viewport" content="width=device-width, initial-scale=1">
				<meta charset = "UTF-8">
				<title>Control De SGI</title>
				<meta name="description" content="Bienvenidos a Control SGI">
				<!-- Se agrega un icono a la pestaña del proyecto .-->
				<link rel="shortcut icon" type="image/png" href="./Public/img/logo.png">
				<link rel="stylesheet" href="./Public/css/estilos.css">
				<link rel="stylesheet" href="./Public/css/responsimple.min.css">
			</head>
			<body>
				<header class="container center header" >
					<div class="item i-b v-middle ph12 lg2 lg-left">
						<h1 class="logo">Control De SGI</h1>	 
					</div>
	');
	// Se valida que el usuario tenga una sesión activa para mostrar las opciones del menú.
	if($_SESSION['ok'])
	{
		print ('<!-- Definiendo el menu de la aplicación -->
					<nav class="item i-b v-middle ph12 lg10 menu lg-right ">
						<ul class ="container">
							<li class="nobullet item inline"><a href="./">Inicio</a></li>
							<li class="nobullet item inline"><a href="usuarios">Usuarios</a></li>
							<li class="nobullet item inline"><a href="clientes">Clientes</a></li>
							<li class="nobullet item inline"><a href="sucursales">Sucursales</a></li>
							<li class="nobullet item inline"><a href="marcas">Marcas</a></li>
							<li class="nobullet item inline"><a href="modelos">Modelos</a></li>
							<li class="nobullet item inline"><a href="tipocomponente">tipocomponente</a></li>
							<li class="nobullet item inline"><a href="equipos">Equipos</a></li>
							<li class="nobullet item inline"><a href="historicos">Historicos de Equipos</a></li>
							<li class="nobullet item inline"><a href="salir">Salir</a></li>

						</ul>
					</nav>
		');
	}
	print ('
				</header>
				<main class="container center main">
				'); 

	?>
