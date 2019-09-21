<?php
	session_start();
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>

	<title>Sisteme Ventas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="divContainer">
			<div>
				<h1 class="titlePanelControl">Panel de Control</h1>
			</div>
			<div class="dashboard">
				<a href="lista_usuarios.php">
					<i class = "fas fa-users"></i>
					<p>
						<strong>Usuarios</strong><br/>
						<span>40</span>						
					</p>
				</a>
				<a href="lista_clientes.php">
					<i class = "fas fa-users"></i>
					<p>
						<strong>Clientes</strong><br/>
						<span>10800</span>						
					</p>
				</a>
				<a href="lista_proveedor.php">
					<i class = "far fa-building"></i>
					<p>
						<strong>Proveedores</strong><br/>
						<span>200</span>						
					</p>
				</a>
				<a href="lista_producto.php">
					<i class = "fas fa-cubes"></i>
					<p>
						<strong>Producto</strong><br/>
						<span>2000</span>						
					</p>
				</a>
				<a href="ventas.php">
					<i class = "far fa-file-alt"></i>
					<p>
						<strong>Ventas</strong><br/>
						<span>500</span>						
					</p>
				</a>

			</div> <!-- <div class="dashboard"> -->

		</div> <!-- <div class="divContainer">-->

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>